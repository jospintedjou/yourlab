<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Initialize tenant context
            tenancy()->initialize($tenant);

            $projects = Project::all();

            foreach ($projects as $project) {
                // Create 1 to 5 tasks per project
                $taskCount = rand(1, 5);
                
                Task::factory($taskCount)->create([
                    'project_id' => $project->id,
                    'assigned_to' => fake()->boolean(50) ? $user->id : null,
                ]);
            }

            $totalTasks = Task::count();
            $this->command->info("✓ Created {$totalTasks} tasks for {$tenant->name}");

            // End tenant context
            tenancy()->end();
        }
    }
}
