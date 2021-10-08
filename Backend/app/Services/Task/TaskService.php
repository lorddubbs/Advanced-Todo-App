<?php

namespace App\Services\Task;

use App\Models\{User, Task};
use App\Notifications\TaskCreation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Str;


class TaskService
{
    protected $taskRepository;  
    protected $userRepository;

    public function __construct(TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }
 

    public function createTask(array $task)
    {
        $task['thumbnail'] = $this->uploadToCloud($task['thumbnail']);
        $task['slug'] = Str::slug($task['title']);
        $task['user_id'] = Auth::id();
        
        $taskData = $this->taskRepository->create($task);
        $taskData->categories()->sync($task['category_id']);
        
        $this->sendTaskCreationNotification($taskData);

        return $this->taskRepository->find($taskData->id);
    }

    public function updateTask(int $taskId, array $data)
    {
        $task = $this->taskRepository->find($taskId);

        if(!empty($data['category_id'])) {
            $task->categories()->sync($data['category_id']);
        }

        $data['thumbnail'] = $this->uploadToCloud($data['thumbnail']);
        $data['slug'] = Str::slug($data['title']);

        $data = array_filter($data);
        return $this->taskRepository->update($taskId, $data);
    }

    public function allTasks()
    {
        return $this->taskRepository->all();
    }

    public function getAllTasks($id)
    {
        $user = $this->userRepository->find($id);
        if (!$user)  {
            throw new \Exception('User not found with ID:.', $id);
        }
        return $user->tasks;
    }

    public function getTaskBySlug($taskSlug)
    { 
        $task = $this->taskRepository->whereArray(['user_id' => Auth::id(), 'slug' => $taskSlug]);
        if (!$task)  {
            throw new \Exception('Task not found with SLUG:.', $taskSlug);
        }
        return $task->first();
    }

    public function getTaskById(int $taskId)
    {
        return $this->taskRepository->find($taskId);
    }

    public function deleteTask(int $taskId)
    {
        return $this->taskRepository->delete($taskId);
    }

    protected function uploadToCloud($image) {
        if (!empty($image)) {
        $upload = $image->storeOnCloudinary('Files');
        return $upload->getSecurePath();
        }
        return NULL;
    }

    private function sendTaskCreationNotification(Task $task)
    {
        $user = User::find(Auth::id());
        try {
            $user->notify(new TaskCreation($user, $task));
        } catch (\Exception $e) {
            //Log::error('Task notification failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Task creation notification failed.', false, $e->getMessage());
        }
    }

}