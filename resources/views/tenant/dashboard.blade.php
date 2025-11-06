@extends('layouts.tenant')

@section('title', 'Tableau de bord')

@section('content')
<div>
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="ml-1 font-medium text-gray-900">Tableau de bord</span>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Tableau de bord</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="rounded-lg shadow-sm p-6" style="background-color: lightblue;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-700 uppercase tracking-wide mb-2">Total des projets</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Project::count() }}</p>
                </div>
                <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
            </div>
        </div>

        <div class="rounded-lg shadow-sm p-6" style="background-color: #f9f9a5;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-yellow-700 uppercase tracking-wide mb-2">Tâches actives</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Task::whereIn('status', [\App\Enums\TaskStatus::TODO->value, \App\Enums\TaskStatus::IN_PROGRESS->value])->count() }}</p>
                </div>
                <svg class="h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>

        <div class="rounded-lg shadow-sm p-6" style="background-color: #b3eeb3;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-green-700 uppercase tracking-wide mb-2">Tâches terminées</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Task::where('status', \App\Enums\TaskStatus::DONE->value)->count() }}</p>
                </div>
                <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-border p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Tâches récentes</h2>
        <div class="space-y-3">
            @forelse(\App\Models\Task::with('project')->latest()->take(5)->get() as $task)
                <div class="flex items-center justify-between p-3 border border-border rounded hover:bg-gray-50">
                    <div>
                        <p class="font-medium text-gray-900">{{ $task->title }}</p>
                        <p class="text-sm text-gray-600">{{ $task->project->name ?? 'Aucun projet' }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs rounded {{ $task->status->color() }}">
                        {{ $task->status->label() }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Aucune tâche récente</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
