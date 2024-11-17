<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Priority;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create priorities
        $priorities = Priority::all();

        // Create categories
        $categories = Category::all();

        // Create users
        $user = User::query()->where('email',"test@gmail.com")->first();
        if (!$user){

            $user = User::factory()->state([
                'email' => 'test@gmail.com'
            ])->create();
        }

        $todos = Todo::factory()->count(5)->create([
            'user_id' => $user->id,
            'priority_id' => $priorities->random()->id,
            'category_id' => $categories->random()->id,
        ]);


        foreach ($todos as $todo) {

            // Create child todos (2nd level)
            $childTodos = Todo::factory()->count(2)->for($todo, 'parent')->create([
                'user_id' => $user->id,
                'priority_id' => $priorities->random()->id,
                'category_id' => $categories->random()->id,
            ]);

            foreach ($childTodos as $childTodo) {
                // Create grandchild todos (3rd level)
                Todo::factory()->count(2)->for($childTodo, 'parent')->create([
                    'user_id' => $user->id,
                    'priority_id' => $priorities->random()->id,
                    'category_id' => $categories->random()->id,
                ]);
            }
        }

    }
}
