<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display tenant dashboard
     */
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'active_tasks' => Task::whereIn('status', [TaskStatus::TODO->value, TaskStatus::IN_PROGRESS->value])->count(),
            'completed_tasks' => Task::where('status', TaskStatus::DONE->value)->count(),
        ];

        $recentProjects = Project::latest()->take(5)->get();
        $recentTasks = Task::with('project')->latest()->take(5)->get();

        return view('tenant.dashboard', compact('stats', 'recentProjects', 'recentTasks'));
    }
}
