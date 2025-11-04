<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TaskService;
use App\Models\Project;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use App\DTO\TaskData;
use Illuminate\Validation\Rule;

class CreateTask extends Component
{
    public $project_id = '';
    public $title = '';
    public $description = '';
    public $status = 'todo';
    public $priority = 'medium';
    public $due_date = '';
    public $assigned_to = null;
    public $tenantId;

    protected function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'priority' => ['required', Rule::enum(TaskPriority::class)],
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    public function mount()
    {
        $this->tenantId = tenant('id');
    }

    public function save(TaskService $taskService)
    {
        $validated = $this->validate();
        
        $taskData = TaskData::fromArray($validated);
        $taskService->createTask($taskData);

        session()->flash('success', 'Tâche créée avec succès !');
        
        return redirect()->route('tenant.tasks.index', ['tenant' => $this->tenantId]);
    }

    public function render()
    {
        $projects = Project::all();
        
        return view('livewire.create-task', [
            'projects' => $projects
        ]);
    }
}
