<?php

namespace App\Traits;

use Elasticsearch\Client;

trait Elasticity
{
    public static function bootSearchable()
    {
        if (config('services.search.enabled')) {
            static::observe(ElasticityObserver::class);
        }
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function elasticsearchIndex(Client $elasticSearchClient)
    {
        $elasticSearchClient->index([
            'index' => $this->getTable(),
            'type' => '_doc',
            'id' => $this->getKey(),
            'description' => $this->toElasticsearchDocumentArray(),
        ]);
    }

    public function elasticsearchDelete(Client $elasticSearchClient)
    {
        $elasticSearchClient->delete([
            'index' => $this->getTable(),
            'type' => '_doc',
            'id' => $this->getKey(),
        ]);
    }
}