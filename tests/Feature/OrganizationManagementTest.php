<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_access_organizations_index(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('organizations.index'));

        $response->assertStatus(200);
        $response->assertSee('Mes organisations');
    }

    public function test_guest_cannot_access_organizations(): void
    {
        $response = $this->get(route('organizations.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_organization(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('organizations.create'));

        $response->assertStatus(200);
        $response->assertSee('Créer une nouvelle organisation');
    }

    public function test_authenticated_user_can_store_organization(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('organizations.store'), [
            'name' => 'Test Organization',
        ]);

        $response->assertRedirect(route('organizations.index'));

        // Find the created tenant (ID is auto-generated)
        $tenant = Tenant::where('name', 'Test Organization')->first();
        $this->assertNotNull($tenant);
        $this->assertEquals('Test Organization', $tenant->name);

        $this->assertDatabaseHas('tenant_user', [
            'tenant_id' => $tenant->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_organization_requires_name(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('organizations.store'), [
            'id' => 'test-org',
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_see_only_their_organizations(): void
    {
        $this->actingAs($this->user);

        $myOrg = Tenant::create(['id' => 'my-org', 'name' => 'My Organization']);
        $myOrg->users()->attach($this->user->id);

        $otherUser = User::factory()->create();
        $otherOrg = Tenant::create(['id' => 'other-org', 'name' => 'Other Organization']);
        $otherOrg->users()->attach($otherUser->id);

        $response = $this->get(route('organizations.index'));

        $response->assertSee('My Organization');
        $response->assertDontSee('Other Organization');
    }

    public function test_user_can_access_tenant_dashboard_of_their_organization(): void
    {
        $this->actingAs($this->user);

        $tenant = Tenant::create(['id' => 'user-tenant', 'name' => 'User Tenant']);
        $tenant->users()->attach($this->user->id);

        // Run tenant migrations
        $this->setUpTenant($tenant);

        tenancy()->initialize($tenant);

        $response = $this->get(route('tenant.dashboard', ['tenant' => $tenant->id]));

        $response->assertStatus(200);
        $response->assertSee('Tableau de bord');

        tenancy()->end();
    }

    public function test_user_cannot_access_tenant_dashboard_of_other_organization(): void
    {
        $this->actingAs($this->user);

        $otherUser = User::factory()->create();
        $otherTenant = Tenant::create(['id' => 'other-tenant', 'name' => 'Other Tenant']);
        $otherTenant->users()->attach($otherUser->id);

        // Run tenant migrations
        $this->setUpTenant($otherTenant);

        tenancy()->initialize($otherTenant);

        $response = $this->get(route('tenant.dashboard', ['tenant' => $otherTenant->id]));

        // Should be forbidden or redirected
        $this->assertTrue(
            $response->status() === 403 || $response->isRedirect()
        );

        tenancy()->end();
    }
}
