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
            // Create 5 projects per organization (single database, using tenant_id)
            Project::factory(5)->create([
                'tenant_id' => $tenant->id,
            ]);

            $this->command->info("✓ Created 5 projects for {$tenant->name}");
        }
    }
}
