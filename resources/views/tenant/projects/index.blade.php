@extends('layouts.tenant')

@section('title', 'Projets')

@section('content')
<div>
    <!-- Breadcrumbs -->
    <x-breadcrumb :items="[
        ['label' => 'Accueil', 'url' => route('tenant.dashboard', ['tenant' => tenant('id')])],
        ['label' => 'Projets']
    ]" />

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Projets</h1>
            <p class="text-gray-600">Gérez tous les projets de votre organisation</p>
        </div>
        <a href="{{ route('tenant.projects.create', ['tenant' => tenant('id')]) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un projet
        </a>
    </div>

    <livewire:project-list />
</div>
@endsection
