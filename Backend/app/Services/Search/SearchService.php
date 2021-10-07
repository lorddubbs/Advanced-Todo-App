<?php

namespace App\Services\Search;

use App\Repositories\Search\ElasticSearchRepository;


class SearchService
{
    protected $searchRepository;  

    public function __construct(ElasticSearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }


    public function searchQuery($query)
    {
        return $this->searchRepository->search($query);
    }

}