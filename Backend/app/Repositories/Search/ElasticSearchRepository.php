<?php

namespace App\Repositories\Search;

use App\Repositories\SearchRepository;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

 class ElasticSearchRepository implements SearchRepository
 {
     /** @var \Elasticsearch\Client */
    private $elasticsearch;
    //protected $taskRepository;  

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
        //$this->taskRepository = $taskRepository;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Task;

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'type' => "phrase_prefix",
                                'fields' => ['title', 'description', 'priority'],
                                'query' => $query,
                            ]
                        ]
                    ]
                ]
            ],
        ]);
        return $items;
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        $tasks = Task::where('user_id', Auth::id())->get();
        return $tasks->whereIn('id', $ids)
            ->sortBy(function ($task) use ($ids) {
                return array_search($task->getKey(), $ids);
        });
    }
 } 
