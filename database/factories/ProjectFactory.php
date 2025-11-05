<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement([ProjectStatus::DRAFT, ProjectStatus::ACTIVE, ProjectStatus::COMPLETED]),
            'start_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'end_date' => fake()->boolean(50) ? fake()->dateTimeBetween('now', '+90 days') : null,
        ];
    }
}
