<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userCount = \App\Models\User::query()->count();
        return [
            'name' => fake()->text(50),
            'description' => fake()->realText(),
            'status_id' => fake()->numberBetween(1, \App\Models\TaskStatus::query()->count()),
            'created_by_id' => fake()->numberBetween(1, $userCount),
            'assigned_to_id' => fake()->numberBetween(1, $userCount)
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (\App\Models\Task $task) {
            $labels = \App\Models\Label::inRandomOrder()->limit(fake()->numberBetween(1, 7))->pluck('id');
            $task->labels()->sync($labels);
        });
    }
}
