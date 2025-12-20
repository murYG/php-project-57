<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
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
        User::factory(10)->create();
        
        TaskStatus::updateOrCreate(['name' => 'новый']);
        TaskStatus::updateOrCreate(['name' => 'в работе']);
        TaskStatus::updateOrCreate(['name' => 'на тестировании']);
        TaskStatus::updateOrCreate(['name' => 'завершен']);
        
        Task::factory(25)->create();
    }
}
