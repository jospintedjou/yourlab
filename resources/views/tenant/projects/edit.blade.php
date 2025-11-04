@extends('layouts.tenant')

@section('title', 'Modifier le projet')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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
        <span class="font-medium text-gray-900">Modifier</span>
    </nav>

    <div class="mb-6">
        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover">
            ← Retour aux projets
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier le projet</h1>

        <livewire:edit-project :projectId="$project->id" />
    </div>
</div>
@endsection
