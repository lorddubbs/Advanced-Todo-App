<?php

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;


class CategoryService
{
    protected $categoryRepository;  
    protected $userRepository;


    public function __construct(CategoryRepository $categoryRepository, UserRepository $userRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }


    public function createCategory(array $category)
    {
        $category['user_id'] = Auth::user()->id;
        $category = $this->categoryRepository->create($category);
        
        return $this->categoryRepository->find($category->id);
    }

    public function updateCategory(int $categoryId, array $data)
    {
        return $this->categoryRepository->update($categoryId, $data);
    }

    public function getAllCategories($id)
    {
        $user = $this->userRepository->find($id);
        if (!$user)  {
            throw new \Exception('User not found with ID:.', $id);
        }
        return $user->categories;
    }

    public function allCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getCategoryById(int $categoryId)
    {
        return $this->categoryRepository->find($categoryId);
    }

    public function deleteCategory(int $categoryId)
    {
        return $this->categoryRepository->delete($categoryId);
    }

}