<?php

namespace App\Services;

use App\DTO\ProjectData;
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
    public function createProject(ProjectData $data): Project
    {
        return $this->projectRepository->create($data->toArray());
    }

    /**
     * Update a project
     */
    public function updateProject(Project $project, ProjectData $data): Project
    {
        return $this->projectRepository->update($project, $data->toArray());
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

    /**
     * Get total projects count
     */
    public function getTotalProjectsCount(): int
    {
        return $this->projectRepository->count();
    }

    /**
     * Get recent projects
     */
    public function getRecentProjects(int $limit = 5): Collection
    {
        return $this->projectRepository->getRecent($limit);
    }
}
