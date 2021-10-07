<?php

namespace Database\Factories;

use App\Models\{Category,Task};
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskCategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task_id' => Task::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
