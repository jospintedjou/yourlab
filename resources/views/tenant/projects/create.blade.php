@extends('layouts.tenant')

@section('title', 'Créer un projet')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <x-breadcrumb :items="[
        ['label' => 'Accueil', 'url' => route('tenant.dashboard', ['tenant' => tenant('id')])],
        ['label' => 'Projets', 'url' => route('tenant.projects.index', ['tenant' => tenant('id')])],
        ['label' => 'Créer']
    ]" />

    <div class="mb-6">
        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover">
            ← Retour aux projets
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Créer un nouveau projet</h1>

        <livewire:create-project />
    </div>
</div>
@endsection
