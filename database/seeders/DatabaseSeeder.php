<?php

namespace Database\Seeders;

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
        // Create test user (skip if already exists)
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
            $this->command->info('✓ Created test user');
        } else {
            $this->command->info('ℹ Test user already exists, skipping...');
        }

        // Run specific seeders in order (only if no tenants exist)
        if (\App\Models\Tenant::count() === 0) {
            $this->call([
                TenantSeeder::class,
                ProjectSeeder::class,
                TaskSeeder::class,
            ]);

            $this->command->info('');
            $this->command->info('🎉 Database seeding completed successfully!');
            $this->command->info('📧 Login: test@example.com');
            $this->command->info('🔑 Password: password');
        } else {
            $this->command->info('ℹ Database already seeded, skipping tenant/project/task creation...');
        }
    }
}
