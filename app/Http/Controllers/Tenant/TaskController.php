<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\DTO\TaskData;
use App\Services\TaskService;
use App\Services\ProjectService;
use App\Models\Task;

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
    public function store(StoreTaskRequest $request)
    {
        $taskData = TaskData::fromArray($request->validated());
        $this->taskService->createTask($taskData);

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
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $taskData = TaskData::fromArray($request->validated());
        $this->taskService->updateTask($task, $taskData);

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
