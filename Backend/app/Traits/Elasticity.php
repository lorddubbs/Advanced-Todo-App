<?php

namespace App\Traits;
use Illuminate\Support\Facades\Log;

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
        Log::info($this->getTable());
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable();
    }

    public function toSearchArray()
    {
        return $this->toArray();
    }
}