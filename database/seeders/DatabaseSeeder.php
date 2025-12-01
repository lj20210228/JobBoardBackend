<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();
        User::factory()->count(5)->create(['role' => 'admin']);
        Company::factory()->count(30)->create();
        Job::factory()->count(80)->create();
        Application::factory()->count(300)->create();
        User::factory()->count(30)->create(['role' => 'student']);
        User::factory()->count(30)->create(['role' => 'alumni']);
        Comment::factory()->count(30)->create();
    }
}
