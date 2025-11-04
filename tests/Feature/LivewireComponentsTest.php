<?php

namespace Tests\Feature;

use App\Livewire\CreateProject;
use App\Livewire\CreateTask;
use App\Livewire\EditProject;
use App\Livewire\EditTask;
use App\Livewire\ProjectList;
use App\Livewire\TaskList;
use App\Models\Project;
use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireComponentsTest extends TestCase
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

        tenancy()->initialize($this->tenant);
    }

    protected function tearDown(): void
    {
        tenancy()->end();
        parent::tearDown();
    }

    public function test_create_project_component_renders(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateProject::class)
            ->assertStatus(200)
            ->assertSee('Nom du projet');
    }

    public function test_create_project_component_validates_required_fields(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateProject::class)
            ->set('name', '')
            ->set('status', '')
            ->call('save')
            ->assertHasErrors(['name', 'status']);
    }

    public function test_create_project_component_creates_project(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateProject::class)
            ->set('name', 'New Project')
            ->set('description', 'Project description')
            ->set('status', 'active')
            ->set('start_date', '2025-01-01')
            ->call('save')
            ->assertRedirect();

        // Verify project was created
        $project = Project::where('name', 'New Project')->first();
        $this->assertNotNull($project);
        $this->assertEquals('Project description', $project->description);
        $this->assertEquals('active', $project->status->value);
    }

    public function test_edit_project_component_renders_with_project_data(): void
    {
        $this->actingAs($this->user);

        $project = Project::create([
            'name' => 'Edit Me',
            'status' => ProjectStatus::DRAFT,
            'start_date' => now(),
        ]);

        Livewire::test(EditProject::class, ['projectId' => $project->id])
            ->assertStatus(200)
            ->assertSet('name', 'Edit Me')
            ->assertSet('status', 'draft');
    }

    public function test_create_task_component_renders(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateTask::class)
            ->assertStatus(200)
            ->assertSee('Titre de la tâche');
    }

    public function test_create_task_component_validates_required_fields(): void
    {
        $this->actingAs($this->user);

        Livewire::test(CreateTask::class)
            ->set('title', '')
            ->set('status', '')
            ->call('save')
            ->assertHasErrors(['title', 'status']);
    }

    public function test_create_task_component_creates_task(): void
    {
        $this->actingAs($this->user);

        $project = Project::create([
            'name' => 'Test Project',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        Livewire::test(CreateTask::class)
            ->set('title', 'New Task')
            ->set('description', 'Task description')
            ->set('status', 'todo')
            ->set('priority', 'high')
            ->set('project_id', $project->id)
            ->call('save')
            ->assertRedirect();

        // Verify task was created
        $task = Task::where('title', 'New Task')->first();
        $this->assertNotNull($task);
        $this->assertEquals('Task description', $task->description);
        $this->assertEquals('todo', $task->status->value);
        $this->assertEquals('high', $task->priority->value);
    }

    public function test_edit_task_component_renders_with_task_data(): void
    {
        $this->actingAs($this->user);

        $project = Project::create([
            'name' => 'Test Project',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        $task = Task::create([
            'title' => 'Edit Me',
            'status' => TaskStatus::TODO,
            'priority' => TaskPriority::MEDIUM,
            'project_id' => $project->id,
        ]);

        Livewire::test(EditTask::class, ['taskId' => $task->id])
            ->assertStatus(200)
            ->assertSet('title', 'Edit Me')
            ->assertSet('status', 'todo')
            ->assertSet('priority', 'medium');
    }

    public function test_project_list_component_displays_projects(): void
    {
        $this->actingAs($this->user);

        Project::create([
            'name' => 'Project 1',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        Project::create([
            'name' => 'Project 2',
            'status' => ProjectStatus::DRAFT,
            'start_date' => now(),
        ]);

        Livewire::test(ProjectList::class)
            ->assertStatus(200)
            ->assertSee('Project 1')
            ->assertSee('Project 2');
    }

    public function test_task_list_component_displays_tasks(): void
    {
        $this->actingAs($this->user);

        $project = Project::create([
            'name' => 'Test Project',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        Task::create([
            'title' => 'Task 1',
            'status' => TaskStatus::TODO,
            'project_id' => $project->id,
        ]);

        Task::create([
            'title' => 'Task 2',
            'status' => TaskStatus::IN_PROGRESS,
            'project_id' => $project->id,
        ]);

        Livewire::test(TaskList::class)
            ->assertStatus(200)
            ->assertSee('Task 1')
            ->assertSee('Task 2');
    }

    public function test_project_list_component_can_delete_project(): void
    {
        $this->actingAs($this->user);

        $project = Project::create([
            'name' => 'Delete Me',
            'status' => ProjectStatus::DRAFT,
            'start_date' => now(),
        ]);

        Livewire::test(ProjectList::class)
            ->call('deleteProject', $project->id)
            ->assertStatus(200);

        // Verify project was deleted
        $this->assertNull(Project::find($project->id));
    }

    public function test_task_list_component_can_delete_task(): void
    {
        $this->actingAs($this->user);

        $project = Project::create([
            'name' => 'Test Project',
            'status' => ProjectStatus::ACTIVE,
            'start_date' => now(),
        ]);

        $task = Task::create([
            'title' => 'Delete Me',
            'status' => TaskStatus::TODO,
            'project_id' => $project->id,
        ]);

        Livewire::test(TaskList::class)
            ->call('deleteTask', $task->id)
            ->assertStatus(200);

        // Verify task was deleted
        $this->assertNull(Task::find($task->id));
    }
}
