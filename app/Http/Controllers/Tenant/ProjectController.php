<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Models\Project;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,active,completed',
        ]);

        $this->projectService->createProject($validated);

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
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,active,completed',
        ]);

        $this->projectService->updateProject($project, $validated);

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
