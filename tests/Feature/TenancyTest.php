<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_central_domain_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_tenant_is_created_successfully(): void
    {
        $user = User::factory()->create();

        $tenant = Tenant::create([
            'id' => 'test-org',
            'name' => 'Test Organization',
        ]);

        $tenant->users()->attach($user->id);

        $this->assertDatabaseHas('tenants', [
            'id' => 'test-org',
            'name' => 'Test Organization',
        ]);

        $this->assertDatabaseHas('tenant_user', [
            'tenant_id' => 'test-org',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_belong_to_multiple_tenants(): void
    {
        $user = User::factory()->create();

        $tenant1 = Tenant::create(['id' => 'org1', 'name' => 'Organization 1']);
        $tenant2 = Tenant::create(['id' => 'org2', 'name' => 'Organization 2']);

        $tenant1->users()->attach($user->id);
        $tenant2->users()->attach($user->id);

        $this->assertCount(2, $user->fresh()->tenants);
        $this->assertTrue($user->tenants->contains($tenant1));
        $this->assertTrue($user->tenants->contains($tenant2));
    }

    public function test_tenant_can_have_multiple_users(): void
    {
        $tenant = Tenant::create(['id' => 'test-org', 'name' => 'Test Org']);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $tenant->users()->attach([$user1->id, $user2->id]);

        $this->assertCount(2, $tenant->fresh()->users);
        $this->assertTrue($tenant->users->contains($user1));
        $this->assertTrue($tenant->users->contains($user2));
    }
}
