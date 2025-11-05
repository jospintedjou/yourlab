<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
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
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement([TaskStatus::TODO, TaskStatus::IN_PROGRESS, TaskStatus::DONE]),
            'priority' => fake()->randomElement([TaskPriority::LOW, TaskPriority::MEDIUM, TaskPriority::HIGH, null]),
            'due_date' => fake()->boolean(50) ? fake()->dateTimeBetween('now', '+60 days') : null,
            'assigned_to' => null, // Will be set in seeder
        ];
    }
}
