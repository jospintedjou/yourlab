<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    /**
     * Get all projects
     */
    public function all(): Collection
    {
        return Project::with('tasks')->latest()->get();
    }

    /**
     * Find a project by ID
     */
    public function find(int $id): ?Project
    {
        return Project::with('tasks')->find($id);
    }

    /**
     * Create a new project
     */
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    /**
     * Update a project
     */
    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh();
    }

    /**
     * Delete a project
     */
    public function delete(Project $project): bool
    {
        return $project->delete();
    }

    /**
     * Get projects by status
     */
    public function getByStatus(string $status): Collection
    {
        return Project::where('status', $status)->with('tasks')->latest()->get();
    }
}
