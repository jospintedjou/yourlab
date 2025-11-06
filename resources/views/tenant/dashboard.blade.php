@extends('layouts.tenant')

@section('title', 'Tableau de bord')

@section('content')
<div>
    <!-- Breadcrumbs -->
    <x-breadcrumb :items="[
        ['label' => 'Tableau de bord']
    ]" />

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Tableau de bord</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stats Cards -->
        <x-stat-card 
            title="Total des projets"
            :value="$stats['total_projects']"
            bg-color="lightblue"
            text-color="text-blue-700"
            icon-color="text-blue-500"
        >
            <x-slot:icon>
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            title="Tâches actives"
            :value="$stats['active_tasks']"
            bg-color="#f9f9a5"
            text-color="text-yellow-700"
            icon-color="text-yellow-500"
        >
            <x-slot:icon>
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            title="Tâches terminées"
            :value="$stats['completed_tasks']"
            bg-color="#b3eeb3"
            text-color="text-green-700"
            icon-color="text-green-500"
        >
            <x-slot:icon>
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Projects -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Projets récents</h2>
            <div class="space-y-3">
                @forelse($recentProjects as $project)
                    <x-list-item 
                        :title="$project->name"
                        :subtitle="Str::limit($project->description ?? 'Aucune description', 60)"
                        :status="$project->status"
                    >
                        <x-slot:icon>
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </x-slot:icon>
                    </x-list-item>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucun projet récent</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Tâches récentes</h2>
            <div class="space-y-3">
                @forelse($recentTasks as $task)
                    <x-list-item 
                        :title="$task->title"
                        :subtitle="$task->project->name ?? 'Aucun projet'"
                        :status="$task->status"
                    >
                        <x-slot:icon>
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </x-slot:icon>
                    </x-list-item>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucune tâche récente</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
