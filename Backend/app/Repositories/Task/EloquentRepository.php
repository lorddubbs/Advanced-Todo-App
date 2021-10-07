<?php

namespace App\Repositories\Task;
use App\Models\Task;
use App\Repositories\SearchRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements SearchRepository
{
    public function search(string $query = ''): LengthAwarePaginator
    {
        return Task::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate();
    }
}