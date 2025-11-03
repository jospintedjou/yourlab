<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use App\Services\ProjectService;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService,
        protected ProjectService $projectService
    ) {}

    /**
     * Display all tasks
     */
    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return view('tenant.tasks.index', compact('tasks'));
    }

    /**
     * Show form to create task
     */
    public function create()
    {
        $projects = $this->projectService->getAllProjects();
        return view('tenant.tasks.create', compact('projects'));
    }

    /**
     * Store a new task
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $this->taskService->createTask($validated);

        return redirect()->route('tenant.tasks.index', ['tenant' => tenant('id')])
            ->with('success', 'Task created successfully!');
    }

    /**
     * Show a specific task
     */
    public function show(Task $task)
    {
        return view('tenant.tasks.show', compact('task'));
    }

    /**
     * Show form to edit task
     */
    public function edit(Task $task)
    {
        $projects = $this->projectService->getAllProjects();
        return view('tenant.tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update a task
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $this->taskService->updateTask($task, $validated);

        return redirect()->route('tenant.tasks.index', ['tenant' => tenant('id')])
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Delete a task
     */
    public function destroy(Task $task)
    {
        $this->taskService->deleteTask($task);

        return redirect()->route('tenant.tasks.index', ['tenant' => tenant('id')])
            ->with('success', 'Task deleted successfully!');
    }
}
