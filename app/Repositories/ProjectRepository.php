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
        // Ensure tenant_id is set for single database multi-tenancy
        if (!isset($data['tenant_id'])) {
            if (tenancy()->initialized) {
                $data['tenant_id'] = tenant('id');
            } else {
                throw new \Exception('Tenant context is not initialized. Cannot create project without tenant_id.');
            }
        }
        
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

    /**
     * Count all projects
     */
    public function count(): int
    {
        return Project::count();
    }

    /**
     * Get recent projects
     */
    public function getRecent(int $limit = 5): Collection
    {
        return Project::latest()->take($limit)->get();
    }
}
