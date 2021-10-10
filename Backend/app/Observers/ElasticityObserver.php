<?php

namespace App\Observers;
use Elasticsearch\Client;

class ElasticityObserver
{
   
    public function __construct(private Client $elasticSearchClient)
    {
        $this->elasticSearchClient = $elasticSearchClient;
    }

    public function saved($model)
    {
        $this->elasticSearchClient->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    public function deleted($model)
    {
        $this->elasticSearchClient->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
