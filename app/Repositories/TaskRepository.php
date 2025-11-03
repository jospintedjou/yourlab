<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    /**
     * Get all tasks
     */
    public function all(): Collection
    {
        return Task::with(['project', 'assignedUser'])->latest()->get();
    }

    /**
     * Find a task by ID
     */
    public function find(int $id): ?Task
    {
        return Task::with(['project', 'assignedUser'])->find($id);
    }

    /**
     * Create a new task
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Update a task
     */
    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    /**
     * Delete a task
     */
    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    /**
     * Get tasks by project
     */
    public function getByProject(Project $project): Collection
    {
        return Task::where('project_id', $project->id)
            ->with('assignedUser')
            ->latest()
            ->get();
    }

    /**
     * Get tasks by status
     */
    public function getByStatus(string $status): Collection
    {
        return Task::where('status', $status)
            ->with(['project', 'assignedUser'])
            ->latest()
            ->get();
    }

    /**
     * Get tasks assigned to a user
     */
    public function getByAssignedUser(int $userId): Collection
    {
        return Task::where('assigned_to', $userId)
            ->with('project')
            ->latest()
            ->get();
    }
}
