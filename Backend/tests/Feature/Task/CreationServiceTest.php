<?php

namespace Tests\Feature\Task;

use App\Models\{User, Category, Task};
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\UserRepository;
use App\Services\Task\TaskService;
use Illuminate\Support\Str;
use Mockery;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskCreation;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreationServiceTest extends TestCase
{
    use RefreshDatabase; 

    protected $taskService;
    protected $taskRepository;
    protected $userRepository;
    protected $user;
    protected $category;
    protected $task;

    public function setup(): void
    {
        parent::setup();

        //user setup
        $this->user = User::create([
            "name" => "John Doe",
            "email" => "johndoe@test.com",
            'password' => Hash::make('password'),
        ]);
        
        //category setup
        $this->category = Category::create([
            "user_id" => $this->user->id,
            "name" => "Recreation"
        ]);

        //task setup
        $this->task = Task::create([
            'user_id' => $this->user->id,
            'title' => 'Light Exercise',
            'slug' => Str::slug('Light Exercise'),
            'description' => 'Firm and Strong',
            'thumbnail' => '',
            'priority' => 'high',
            'access' => '0',
            'start_date' => '2021-10-08',
            'end_date' => '2021-10-10'
        ]);

        //$this->task->users()->sync($this->user->id);
        $this->task->categories()->sync($this->category->id);

        $this->taskRepository = new TaskRepository(new Task());
        $this->userRepository = new UserRepository(new User());
        
        $this->taskService = new TaskService($this->taskRepository, $this->userRepository);
    }

    /*
    public function testCreateTask()
    {

        $taskData = [
            "title" => "Start Laundry",
            "slug" => Str::slug("Start Laundry"),
            "description" => "Cleaning up at the laundry mart",
            'thumbnail' => '',
            "priority" => "low",
            "start_date" => "2021-10-1",
            "end_date" => "2021-10-2",
            "access" => "1" 
        ];

        $taskCreated = $this->taskService->createTask($taskData);
        $this->assertEquals($taskCreated['user_id'], $taskData['user_id']);
        $this->assertEquals($taskCreated['title'], $taskData['title']);
        $this->assertEquals($taskCreated['slug'], $taskData['slug']);
        $this->assertEquals($taskCreated['description'], $taskData['description']);
        $this->assertEquals($taskCreated['thumbnail'], $taskData['thumbnail']);
        $this->assertEquals($taskCreated['priority'], $taskData['priority']);
        $this->assertEquals($taskCreated['start_date'], $taskData['start_date']);
        $this->assertEquals($taskCreated['end_date'], $taskData['end_date']);
        $this->assertArrayHasKey('priority', $taskCreated);
        $this->assertArrayHasKey('access', $taskCreated);
    }
    */

    public function testGetATaskForUser()
    {
       $result = $this->taskService->getTaskById($this->task->id);
       $this->assertNotEmpty($result);
    }

    public function testGetAllTasksForUser()
    {
       $result = $this->taskService->getAllTasks($this->user->id);
       $this->assertNotEmpty($result);
    }

    public function testGetAllTasks()
    {
       $result = $this->taskService->allTasks();
       $this->assertNotEmpty($result);
    }

    public function testDeleteTask()
    {
        $taskData = [];
        $result = $this->taskService->deleteTask($this->task->id, $taskData);
        $this->assertNotEmpty($result);
    }

    public function testCreateTaskNotification():void {
        Notification::fake();
        $user = $this->user;
        $task = $this->task;
        $this->user->notify(new TaskCreation($this->user, $this->task));
        Notification::assertSentTo($this->user, TaskCreation::class, function($notification, $channels) {
            return in_array('mail', $channels);
        });
    }

}
