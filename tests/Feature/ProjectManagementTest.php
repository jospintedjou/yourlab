<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Tenant;
use App\Models\User;
use App\Enums\ProjectStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        
        $this->tenant = Tenant::create([
            'id' => 'test-tenant',
            'name' => 'Test Tenant',
        ]);

        $this->tenant->users()->attach($this->user->id);

        // Run tenant migrations
        $this->setUpTenant($this->tenant);
    }

    public function test_authenticated_user_can_access_projects_index(): void
    {
        $this->actingAs($this->user);

        tenancy()->initialize($this->tenant);

        $response = $this->get(route('tenant.projects.index', ['tenant' => $this->tenant->id]));

        $response->assertStatus(200);
        $response->assertSee('Projets');
    }

    public function test_guest_cannot_access_projects(): void
    {
        tenancy()->initialize($this->tenant);

        $response = $this->get(route('tenant.projects.index', ['tenant' => $this->tenant->id]));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_project(): void
    {
        $this->actingAs($this->user);

        tenancy()->initialize($this->tenant);

        $response = $this->get(route('tenant.projects.create', ['tenant' => $this->tenant->id]));

        $response->assertStatus(200);
        $response->assertSeeLivewire('create-project');
    }

    public function test_project_belongs_to_tenant(): void
    {
        tenancy()->initialize($this->tenant);

        $project = Project::create([
            'name' => 'Tenant Project',
            'description' => 'A project for testing',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        // Verify project was created
        $this->assertNotNull($project->id);
        $this->assertEquals('Tenant Project', $project->name);
        $this->assertEquals($this->tenant->id, $project->tenant_id);

        // Verify it exists in the tenant database
        $foundProject = Project::where('name', 'Tenant Project')->first();
        $this->assertNotNull($foundProject);
        
        tenancy()->end();
    }

    public function test_authenticated_user_can_view_project_details(): void
    {
        $this->actingAs($this->user);

        tenancy()->initialize($this->tenant);

        $project = Project::create([
            'name' => 'View Test Project',
            'description' => 'Testing project view',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        $response = $this->get(route('tenant.projects.show', [
            'tenant' => $this->tenant->id,
            'project' => $project->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee('View Test Project');
        $response->assertSee('Testing project view');
    }

    public function test_authenticated_user_can_edit_project(): void
    {
        $this->actingAs($this->user);

        tenancy()->initialize($this->tenant);

        $project = Project::create([
            'name' => 'Edit Test Project',
            'status' => ProjectStatus::DRAFT,
            'start_date' => now(),
        ]);

        $response = $this->get(route('tenant.projects.edit', [
            'tenant' => $this->tenant->id,
            'project' => $project->id,
        ]));

        $response->assertStatus(200);
        $response->assertSeeLivewire('edit-project');
    }
}
