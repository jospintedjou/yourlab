<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tenant $tenant;
    protected Project $project;

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

        tenancy()->initialize($this->tenant);

        $this->project = Project::create([
            'name' => 'Test Project',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);
    }

    protected function tearDown(): void
    {
        tenancy()->end();
        parent::tearDown();
    }

    public function test_authenticated_user_can_access_tasks_index(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tenant.tasks.index', ['tenant' => $this->tenant->id]));

        $response->assertStatus(200);
        $response->assertSee('Tâches');
    }

    public function test_guest_cannot_access_tasks(): void
    {
        $response = $this->get(route('tenant.tasks.index', ['tenant' => $this->tenant->id]));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_task(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tenant.tasks.create', ['tenant' => $this->tenant->id]));

        $response->assertStatus(200);
        $response->assertSeeLivewire('create-task');
    }

    public function test_task_belongs_to_project(): void
    {
        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Task description',
            'status' => TaskStatus::TODO,
            'priority' => TaskPriority::MEDIUM,
            'project_id' => $this->project->id,
        ]);

        $this->assertEquals($this->project->id, $task->project_id);
        $this->assertTrue($task->project->is($this->project));
    }

    public function test_task_belongs_to_tenant(): void
    {
        $task = Task::create([
            'title' => 'Tenant Task',
            'status' => TaskStatus::TODO,
            'priority' => TaskPriority::HIGH,
            'project_id' => $this->project->id,
        ]);

        // Verify task was created
        $this->assertNotNull($task->id);
        $this->assertEquals('Tenant Task', $task->title);
        $this->assertEquals($this->project->id, $task->project_id);

        // Verify it exists in the tenant database
        $foundTask = Task::where('title', 'Tenant Task')->first();
        $this->assertNotNull($foundTask);
    }

    public function test_authenticated_user_can_view_task_details(): void
    {
        $this->actingAs($this->user);

        $task = Task::create([
            'title' => 'View Test Task',
            'description' => 'Testing task view',
            'status' => TaskStatus::IN_PROGRESS,
            'priority' => TaskPriority::HIGH,
            'project_id' => $this->project->id,
        ]);

        $response = $this->get(route('tenant.tasks.show', [
            'tenant' => $this->tenant->id,
            'task' => $task->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee('View Test Task');
        $response->assertSee('Testing task view');
    }

    public function test_authenticated_user_can_edit_task(): void
    {
        $this->actingAs($this->user);

        $task = Task::create([
            'title' => 'Edit Test Task',
            'status' => TaskStatus::TODO,
            'priority' => TaskPriority::LOW,
            'project_id' => $this->project->id,
        ]);

        $response = $this->get(route('tenant.tasks.edit', [
            'tenant' => $this->tenant->id,
            'task' => $task->id,
        ]));

        $response->assertStatus(200);
        $response->assertSeeLivewire('edit-task');
    }

    public function test_project_can_have_multiple_tasks(): void
    {
        Task::create([
            'title' => 'Task 1',
            'status' => TaskStatus::TODO,
            'project_id' => $this->project->id,
        ]);

        Task::create([
            'title' => 'Task 2',
            'status' => TaskStatus::IN_PROGRESS,
            'project_id' => $this->project->id,
        ]);

        Task::create([
            'title' => 'Task 3',
            'status' => TaskStatus::DONE,
            'project_id' => $this->project->id,
        ]);

        $this->assertCount(3, $this->project->fresh()->tasks);
    }

    public function test_task_can_have_nullable_priority(): void
    {
        $task = Task::create([
            'title' => 'No Priority Task',
            'status' => TaskStatus::TODO,
            'priority' => null,
            'project_id' => $this->project->id,
        ]);

        $this->assertNull($task->priority);
    }

    public function test_task_can_have_due_date(): void
    {
        $dueDate = now()->addDays(7);

        $task = Task::create([
            'title' => 'Task with Due Date',
            'status' => TaskStatus::TODO,
            'priority' => TaskPriority::HIGH,
            'due_date' => $dueDate,
            'project_id' => $this->project->id,
        ]);

        $this->assertNotNull($task->due_date);
        $this->assertEquals($dueDate->format('Y-m-d'), $task->due_date->format('Y-m-d'));
    }
}
