<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TaskService;
use App\Models\Task;
use App\Models\Project;

class EditTask extends Component
{
    public $taskId;
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

    public function mount($taskId)
    {
        $this->tenantId = tenant('id');
        $this->taskId = $taskId;
        
        $task = Task::findOrFail($taskId);
        $this->project_id = $task->project_id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->priority = $task->priority;
        $this->due_date = $task->due_date;
        $this->assigned_to = $task->assigned_to;
    }

    public function update(TaskService $taskService)
    {
        $validated = $this->validate();
        
        $taskService->updateTask($this->taskId, $validated);

        session()->flash('success', 'Task updated successfully!');
        
        return redirect()->route('tenant.tasks.index', ['tenant' => $this->tenantId]);
    }

    public function render()
    {
        $projects = Project::all();
        
        return view('livewire.edit-task', [
            'projects' => $projects
        ]);
    }
}
