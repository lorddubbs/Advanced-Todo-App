<?php

namespace Tests\Feature\Category;

use App\Models\{User, Category};
use App\Repositories\Category\CategoryRepository;
use App\Repositories\User\UserRepository;
use App\Services\Category\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $categoryService;
    protected $categoryRepository;
    protected $userRepository;
    protected $user;
    protected $category;

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

        //$this->category->users()->attach($this->user->id);

        $this->categoryRepository = new CategoryRepository(new Category());
        $this->userRepository = new UserRepository(new User());

        $this->categoryService = new CategoryService($this->categoryRepository, $this->userRepository);
    }

    public function testGetACategoryForUser()
    {
       $result = $this->categoryService->getCategoryById($this->category->id);
       $this->assertNotEmpty($result);
    }

    public function testGetAllCategoriesForUser()
    {
       $result = $this->categoryService->getAllCategories($this->user->id);
       $this->assertNotEmpty($result);
    }

    public function testGetAllCategories()
    {
       $result = $this->categoryService->allCategories();
       $this->assertNotEmpty($result);
    }

    /*
    public function testCreateCategory()
    {
        $categoryData = [
            "user_id" => $this->user->id,
            "name" => "Recreation" 
        ];

        $categoryCreated = $this->categoryService->createCategory($categoryData);
        $this->assertEquals($categoryCreated['user_id'], $categoryData['user_id']);
        $this->assertEquals($categoryCreated['name'], $categoryData['name']);
    }
    */

    public function testDeleteCategory()
    {
        $categoryData = [];
        $result = $this->categoryService->deleteCategory($this->category->id, $categoryData);
        $this->assertNotEmpty($result);
    }

    
}
