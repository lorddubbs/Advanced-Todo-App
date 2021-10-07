<?php

namespace Tests\Feature\Comment;

use App\Models\{User, Task, Comment};
use App\Repositories\Comment\CommentRepository;
use App\Services\Comment\CommentService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $commentService;
    protected $commentRepository;
    protected $task;
    protected $user;
    protected $comment;

    public function setup(): void
    {
        parent::setup();
        
        //user setup
        $this->user = User::create([
            "name" => "John Doe",
            "email" => "johndoe@test.com",
            'password' => Hash::make('password'),
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

        //category setup
        $this->comment = Comment::create([
            'task_id' => $this->task->id,
            'comment' => 'Procastination is the enemy'
        ]);

        //$this->comment->tasks()->attach($this->task->id);
        $this->commentRepository = new CommentRepository(new Comment());
        $this->commentService = new CommentService($this->commentRepository);
    }

    public function testGetCommentForATask()
    {
       $result = $this->commentService->getCommentById($this->comment->id);
       $this->assertNotEmpty($result);
    }

    public function testDeleteComment()
    {
        $commentData = [];
        $result = $this->commentService->deleteComment($this->comment->id);
        $this->assertNotEmpty($result);
    }

}
