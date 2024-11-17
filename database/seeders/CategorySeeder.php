<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' =>"Technology"]);
        Category::create(['name' =>"Chores"]);
        Category::create(['name' =>"School Work"]);
        Category::create(['name' =>"Work"]);
    }
}
