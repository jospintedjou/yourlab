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
        // Ensure tenant_id is set for single database multi-tenancy
        if (!isset($data['tenant_id'])) {
            if (tenancy()->initialized) {
                $data['tenant_id'] = tenant('id');
            } else {
                throw new \Exception('Tenant context is not initialized. Cannot create task without tenant_id.');
            }
        }
        
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

    /**
     * Count tasks by status
     */
    public function countByStatus(string $status): int
    {
        return Task::where('status', $status)->count();
    }

    /**
     * Count tasks by multiple statuses
     */
    public function countByStatuses(array $statuses): int
    {
        return Task::whereIn('status', $statuses)->count();
    }

    /**
     * Get recent tasks
     */
    public function getRecent(int $limit = 5): Collection
    {
        return Task::with('project')->latest()->take($limit)->get();
    }
}
