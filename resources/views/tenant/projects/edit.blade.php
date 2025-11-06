@extends('layouts.tenant')

@section('title', 'Modifier le projet')

@section('content')
<div>
    <!-- Breadcrumbs and Back Link -->
    <div class="flex items-center justify-between mb-6">
        <x-breadcrumb :items="[
            ['label' => 'Accueil', 'url' => route('tenant.dashboard', ['tenant' => tenant('id')])],
            ['label' => 'Projets', 'url' => route('tenant.projects.index', ['tenant' => tenant('id')])],
            ['label' => 'Modifier']
        ]" />
        
        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover whitespace-nowrap">
            ← Retour aux projets
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-border p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier le projet</h1>
                <p class="text-gray-600">Mettez à jour les informations du projet</p>
            </div>

            <livewire:edit-project :projectId="$project->id" />
        </div>
    </div>
</div>
@endsection
