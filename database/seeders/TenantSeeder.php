<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        // Create 5 organizations for the test user
        for ($i = 1; $i <= 5; $i++) {
            $tenant = Tenant::factory()->create([
                'id' => 'org-' . $i,
            ]);

            // Attach user to tenant
            $tenant->users()->attach($user->id);

            $this->command->info("✓ Created organization: {$tenant->name} (org-{$i})");
        }
    }
}
