<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Initialize tenant context
            tenancy()->initialize($tenant);

            // Create 5 projects per organization
            Project::factory(5)->create();

            $this->command->info("✓ Created 5 projects for {$tenant->name}");

            // End tenant context
            tenancy()->end();
        }
    }
}
