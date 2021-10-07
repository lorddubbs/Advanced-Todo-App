<?php

namespace Database\Factories;

use App\Models\{Task,User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text($maxNbChars = 140),
            'thumbnail' => $this->faker->imageUrl($width = 640, $height = 480),
            'priority' => $this->faker->randomElement($array = array ('low', 'medium', 'high')),
            'start_date' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
            'end_date' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null)
        ];
    }
}
