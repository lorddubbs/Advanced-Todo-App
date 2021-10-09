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
        $model->elasticSearchIndex($this->elasticSearchClient);
    }

    public function deleted($model)
    {
        $model->elasticSearchDelete($this->elasticSearchClient);
    }
}
