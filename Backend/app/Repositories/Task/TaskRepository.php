<?php

namespace App\Repositories\Task;

use App\Repositories\BaseRepository;
use App\Models\Task;

class TaskRepository extends BaseRepository
{
    protected $taskModel;

    public function __construct(Task $taskModel)
    {
        parent::__construct($taskModel);
    }
}
