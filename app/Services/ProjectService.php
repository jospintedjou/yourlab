<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function __construct(
        protected ProjectRepository $projectRepository
    ) {}

    /**
     * Get all projects
     */
    public function getAllProjects(): Collection
    {
        return $this->projectRepository->all();
    }

    /**
     * Get project by ID
     */
    public function getProject(int $id): ?Project
    {
        return $this->projectRepository->find($id);
    }

    /**
     * Create a new project
     */
    public function createProject(array $data): Project
    {
        return $this->projectRepository->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    /**
     * Update a project
     */
    public function updateProject(Project $project, array $data): Project
    {
        return $this->projectRepository->update($project, $data);
    }

    /**
     * Delete a project
     */
    public function deleteProject(Project $project): bool
    {
        return $this->projectRepository->delete($project);
    }

    /**
     * Get projects by status
     */
    public function getProjectsByStatus(string $status): Collection
    {
        return $this->projectRepository->getByStatus($status);
    }
}
