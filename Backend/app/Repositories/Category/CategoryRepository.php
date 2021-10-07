<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    protected $categoryModel;

    public function __construct(Category $categoryModel)
    {
        parent::__construct($categoryModel);
    }
}
