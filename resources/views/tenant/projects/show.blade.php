@extends('layouts.tenant')

@section('title', $project->name)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <a href="{{ route('tenant.dashboard', ['tenant' => tenant('id')]) }}" class="ml-1 hover:text-primary">Accueil</a>
        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="hover:text-primary">Projets</a>
        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-900">{{ $project->name }}</span>
    </nav>

    <div class="mb-6">
        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover">
            ← Retour aux projets
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                <h1 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tenant.projects.edit', ['tenant' => tenant('id'), 'project' => $project->id]) }}" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier le projet
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Statut</h3>
                <span class="px-3 py-1 text-sm rounded-full {{ $project->status->color() }}">
                    {{ $project->status->label() }}
                </span>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Nombre de tâches</h3>
                <p class="text-lg font-semibold text-gray-900">{{ $project->tasks->count() }} tâches</p>
            </div>

            @if($project->start_date)
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Date de début</h3>
                <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($project->start_date)->locale('fr')->isoFormat('D MMMM Y') }}</p>
            </div>
            @endif

            @if($project->end_date)
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Date de fin</h3>
                <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($project->end_date)->locale('fr')->isoFormat('D MMMM Y') }}</p>
            </div>
            @endif
        </div>

        @if($project->description)
        <div class="mb-8">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
            <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
        </div>
        @endif

        <!-- Tasks Section -->
        <div class="border-t border-gray-200 pt-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Tâches du projet</h2>
                <a href="{{ route('tenant.tasks.create', ['tenant' => tenant('id')]) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter une tâche
                </a>
            </div>

            @if($project->tasks->count() > 0)
                <div class="space-y-3">
                    @foreach($project->tasks as $task)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <a href="{{ route('tenant.tasks.show', ['tenant' => tenant('id'), 'task' => $task->id]) }}" class="text-lg font-medium text-gray-900 hover:text-primary">
                                        {{ $task->title }}
                                    </a>
                                </div>
                                @if($task->description)
                                    <p class="text-sm text-gray-600 mt-1 ml-7">{{ Str::limit($task->description, 100) }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 text-xs rounded-full {{ $task->status->color() }}">
                                    {{ $task->status->label() }}
                                </span>
                                @if($task->priority)
                                    <span class="px-3 py-1 text-xs rounded-full {{ $task->priority->color() }}">
                                        {{ $task->priority->label() }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="mt-4 text-gray-500">Aucune tâche pour le moment. Créez votre première tâche !</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
