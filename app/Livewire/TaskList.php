<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

class TaskList extends Component
{
    use WithPagination;

    public $tenantId;
    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = ['search', 'statusFilter', 'priorityFilter'];

    public function mount()
    {
        $this->tenantId = tenant('id');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPriorityFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();
        
        session()->flash('success', 'Task deleted successfully!');
    }

    public function render()
    {
        $tasks = Task::query()
            ->with(['project', 'assignedUser'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->priorityFilter, function ($query) {
                $query->where('priority', $this->priorityFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.task-list', [
            'tasks' => $tasks,
            'statuses' => TaskStatus::cases(),
            'priorities' => TaskPriority::cases()
        ]);
    }
}
