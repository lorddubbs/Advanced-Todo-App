<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function search()
    {
        try {
            if(!is_null(request('query'))) {
            $search = $this->searchService->searchQuery(request('query'));
            return formatResponse(200, 'Search successful.', true, $search);
            }
            return formatResponse(200, 'Empty Query.', true);
        } catch (\Exception $e) {
            //Log::error('Tasks retrieval failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Search failed.', false, $e->getMessage());
        }
    }


}
