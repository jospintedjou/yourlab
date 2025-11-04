<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\DTO\ProjectData;
use App\Services\ProjectService;
use App\Models\Project;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {}

    /**
     * Display all projects
     */
    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return view('tenant.projects.index', compact('projects'));
    }

    /**
     * Show form to create project
     */
    public function create()
    {
        return view('tenant.projects.create');
    }

    /**
     * Store a new project
     */
    public function store(StoreProjectRequest $request)
    {
        $projectData = ProjectData::fromArray($request->validated());
        $this->projectService->createProject($projectData);

        return redirect()->route('tenant.projects.index', ['tenant' => tenant('id')])
            ->with('success', 'Project created successfully!');
    }

    /**
     * Show a specific project
     */
    public function show(Project $project)
    {
        return view('tenant.projects.show', compact('project'));
    }

    /**
     * Show form to edit project
     */
    public function edit(Project $project)
    {
        return view('tenant.projects.edit', compact('project'));
    }

    /**
     * Update a project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $projectData = ProjectData::fromArray($request->validated());
        $this->projectService->updateProject($project, $projectData);

        return redirect()->route('tenant.projects.index', ['tenant' => tenant('id')])
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Delete a project
     */
    public function destroy(Project $project)
    {
        $this->projectService->deleteProject($project);

        return redirect()->route('tenant.projects.index', ['tenant' => tenant('id')])
            ->with('success', 'Project deleted successfully!');
    }
}
