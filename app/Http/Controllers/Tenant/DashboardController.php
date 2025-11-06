<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\TaskService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected TaskService $taskService
    ) {}

    /**
     * Display tenant dashboard
     */
    public function index()
    {
        $stats = [
            'total_projects' => $this->projectService->getTotalProjectsCount(),
            'active_tasks' => $this->taskService->getActiveTasksCount([
                TaskStatus::TODO->value, 
                TaskStatus::IN_PROGRESS->value
            ]),
            'completed_tasks' => $this->taskService->getCompletedTasksCount(TaskStatus::DONE->value),
        ];

        $recentProjects = $this->projectService->getRecentProjects(5);
        $recentTasks = $this->taskService->getRecentTasks(5);

        return view('tenant.dashboard', compact('stats', 'recentProjects', 'recentTasks'));
    }
}
