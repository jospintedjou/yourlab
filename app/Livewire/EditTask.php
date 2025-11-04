<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TaskService;
use App\Models\Task;
use App\Models\Project;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use App\DTO\TaskData;
use Illuminate\Validation\Rule;

class EditTask extends Component
{
    public $taskId;
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

    public function mount($taskId)
    {
        $this->tenantId = tenant('id');
        $this->taskId = $taskId;
        
        $task = Task::findOrFail($taskId);
        $this->project_id = $task->project_id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status->value;
        $this->priority = $task->priority?->value ?? 'medium';
        $this->due_date = $task->due_date ? $task->due_date->format('Y-m-d') : '';
        $this->assigned_to = $task->assigned_to;
    }

    public function update(TaskService $taskService)
    {
        $validated = $this->validate();
        
        $task = Task::findOrFail($this->taskId);
        $taskData = TaskData::fromArray($validated);
        $taskService->updateTask($task, $taskData);

        session()->flash('success', 'Tâche mise à jour avec succès !');
        
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
