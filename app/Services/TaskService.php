<?php

namespace App\Services;

use App\DTO\TaskData;
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
    public function createTask(TaskData $data): Task
    {
        return $this->taskRepository->create($data->toArray());
    }

    /**
     * Update a task
     */
    public function updateTask(Task $task, TaskData $data): Task
    {
        return $this->taskRepository->update($task, $data->toArray());
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

    /**
     * Get active tasks count
     */
    public function getActiveTasksCount(array $statuses): int
    {
        return $this->taskRepository->countByStatuses($statuses);
    }

    /**
     * Get completed tasks count
     */
    public function getCompletedTasksCount(string $status): int
    {
        return $this->taskRepository->countByStatus($status);
    }

    /**
     * Get recent tasks
     */
    public function getRecentTasks(int $limit = 5): Collection
    {
        return $this->taskRepository->getRecent($limit);
    }
}
