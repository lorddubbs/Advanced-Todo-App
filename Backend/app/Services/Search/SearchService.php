<?php

namespace App\Services\Search;

use App\Repositories\SearchRepository;


class SearchService
{
    protected $searchRepository;  

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }


    public function searchQuery($query)
    {
        return $this->searchRepository->search($query);
    }

}