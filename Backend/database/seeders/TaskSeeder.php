<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = [
            [
                'id' => '1', 
                'user_id' => '1',
                'title' => 'Workout Plan', 
                'slug' => Str::slug('Workout Plan'), 
                'description' => 'Getting back to tip top shape.', 
                'thumbnail' => 'http://gym.com/image.png', 
                'priority' => 'low',
                'start_date' => '2021-9-30',
                'end_date' => '2021-10-1', 
                'access' => '1'],
            [
                'id' => '2', 
                'user_id' => '1',
                'title' => 'Fix the car', 
                'slug' => Str::slug('Fix the car'), 
                'description' => 'Some Garage work.', 
                'thumbnail' => '', 
                'priority' => 'medium',
                'start_date' => '2021-10-2',
                'end_date' => '2021-10-3', 
                'access' => '0'],
            [
                'id' => '3', 
                'user_id' => '1',
                'title' => 'Drinks with the boys', 
                'slug' => Str::slug('Drinks with the boys'), 
                'description' => '', 
                'thumbnail' => '', 
                'priority' => 'high',
                'start_date' => '2021-10-4',
                'end_date' => '2021-10-5', 
                'access' => '1'],
        ];

        foreach ($tasks as $task) {
            Task::firstOrCreate([
                'id' => $task['id'],
                'title' => $task['title'],
                'slug' => $task['slug'],
                'description' => $task['description'],
                'thumbnail' => $task['thumbnail'],
                'priority' => $task['priority'],
                'start_date' => $task['start_date'],
                'end_date' => $task['end_date'],
                'access' => $task['access']
            ]);
        }

        unset($tasks);
    }
}
