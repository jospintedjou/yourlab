@extends('layouts.tenant')

@section('title', $task->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <a href="{{ route('tenant.dashboard', ['tenant' => tenant('id')]) }}" class="ml-1 hover:text-primary">Accueil</a>
        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('tenant.tasks.index', ['tenant' => tenant('id')]) }}" class="hover:text-primary">Tâches</a>
        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-900">{{ Str::limit($task->title, 30) }}</span>
    </nav>

    <div class="mb-6">
        <a href="{{ route('tenant.tasks.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover">
            ← Retour aux tâches
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <h1 class="text-3xl font-bold text-gray-900">{{ $task->title }}</h1>
            </div>
            <a href="{{ route('tenant.tasks.edit', ['tenant' => tenant('id'), 'task' => $task->id]) }}" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier la tâche
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Projet</h3>
                @if($task->project)
                    <a href="{{ route('tenant.projects.show', ['tenant' => tenant('id'), 'project' => $task->project->id]) }}" class="text-lg font-medium text-primary hover:text-primary-hover">
                        {{ $task->project->name }}
                    </a>
                @else
                    <p class="text-gray-400">Aucun projet</p>
                @endif
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Statut</h3>
                <span class="px-3 py-1 text-sm rounded-full {{ $task->status->color() }}">
                    {{ $task->status->label() }}
                </span>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Priorité</h3>
                @if($task->priority)
                    <span class="px-3 py-1 text-sm rounded-full {{ $task->priority->color() }}">
                        {{ $task->priority->label() }}
                    </span>
                @else
                    <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                        Non définie
                    </span>
                @endif
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-1">Date d'échéance</h3>
                @if($task->due_date)
                    <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($task->due_date)->locale('fr')->isoFormat('D MMMM Y') }}</p>
                @else
                    <p class="text-gray-400">Non définie</p>
                @endif
            </div>
        </div>

        @if($task->description)
        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700 whitespace-pre-line">{{ $task->description }}</p>
            </div>
        </div>
        @endif

        @if($task->assignedUser)
        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Assignée à</h3>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center">
                    {{ substr($task->assignedUser->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $task->assignedUser->name }}</p>
                    <p class="text-sm text-gray-500">{{ $task->assignedUser->email }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="border-t border-gray-200 pt-6 mt-6">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div>
                    <p>Créée le : {{ $task->created_at->locale('fr')->isoFormat('D MMMM Y à HH:mm') }}</p>
                    @if($task->updated_at != $task->created_at)
                        <p class="mt-1">Modifiée le : {{ $task->updated_at->locale('fr')->isoFormat('D MMMM Y à HH:mm') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
