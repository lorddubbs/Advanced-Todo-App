<?php

namespace App\Repositories\Task;
use App\Models\Task;
use App\Repositories\SearchRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements SearchRepository
{
    public function search(string $query = ''): Collection
    {
        return Task::query()
            ->where('title', 'like', "%{$query}%")
            ->where('user_id', Auth::id())
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
    }
}