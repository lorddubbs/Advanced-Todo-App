<?php

namespace App\Repositories\Search;

use App\Repositories\SearchRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Task;
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
                    'multi_match' => [
                        'fields' => ['title', 'description'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Task::findMany($ids)
            ->sortBy(function ($task) use ($ids) {
                return array_search($task->getKey(), $ids);
            });
    }
 } 
