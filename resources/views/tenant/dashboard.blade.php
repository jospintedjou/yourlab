@extends('layouts.tenant')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Projects</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Project::count() }}</p>
                </div>
                <svg class="h-12 w-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Tasks</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Task::whereIn('status', ['todo', 'in_progress'])->count() }}</p>
                </div>
                <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>

        <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Completed Tasks</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Task::where('status', 'done')->count() }}</p>
                </div>
                <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-border p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Tasks</h2>
        <div class="space-y-3">
            @forelse(\App\Models\Task::with('project')->latest()->take(5)->get() as $task)
                <div class="flex items-center justify-between p-3 border border-border rounded hover:bg-gray-50">
                    <div>
                        <p class="font-medium text-gray-900">{{ $task->title }}</p>
                        <p class="text-sm text-gray-600">{{ $task->project->name ?? 'No project' }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs rounded {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No recent tasks</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
