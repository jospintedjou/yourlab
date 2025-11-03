<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TaskService;
use App\Models\Project;

class CreateTask extends Component
{
    public $project_id = '';
    public $title = '';
    public $description = '';
    public $status = 'todo';
    public $priority = 'medium';
    public $due_date = '';
    public $assigned_to = '';
    public $tenantId;

    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:todo,in_progress,done',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
        'assigned_to' => 'nullable|exists:users,id',
    ];

    public function mount()
    {
        $this->tenantId = tenant('id');
    }

    public function save(TaskService $taskService)
    {
        $validated = $this->validate();
        
        $taskService->createTask($validated);

        session()->flash('success', 'Task created successfully!');
        
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
