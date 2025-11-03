<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    /**
     * Get all tasks
     */
    public function getAllTasks(): Collection
    {
        return $this->taskRepository->all();
    }

    /**
     * Get task by ID
     */
    public function getTask(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    /**
     * Create a new task
     */
    public function createTask(array $data): Task
    {
        return $this->taskRepository->create([
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'todo',
            'assigned_to' => $data['assigned_to'] ?? null,
        ]);
    }

    /**
     * Update a task
     */
    public function updateTask(Task $task, array $data): Task
    {
        return $this->taskRepository->update($task, $data);
    }

    /**
     * Delete a task
     */
    public function deleteTask(Task $task): bool
    {
        return $this->taskRepository->delete($task);
    }

    /**
     * Get tasks by project
     */
    public function getTasksByProject(Project $project): Collection
    {
        return $this->taskRepository->getByProject($project);
    }

    /**
     * Get tasks by status
     */
    public function getTasksByStatus(string $status): Collection
    {
        return $this->taskRepository->getByStatus($status);
    }

    /**
     * Get tasks assigned to a user
     */
    public function getTasksByAssignedUser(int $userId): Collection
    {
        return $this->taskRepository->getByAssignedUser($userId);
    }
}
