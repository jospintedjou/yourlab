@extends('layouts.tenant')

@section('title', 'Créer une tâche')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <x-breadcrumb :items="[
        ['label' => 'Accueil', 'url' => route('tenant.dashboard', ['tenant' => tenant('id')])],
        ['label' => 'Tâches', 'url' => route('tenant.tasks.index', ['tenant' => tenant('id')])],
        ['label' => 'Créer']
    ]" />

    <div class="mb-6">
        <a href="{{ route('tenant.tasks.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover">
            ← Retour aux tâches
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Créer une nouvelle tâche</h1>

        <livewire:create-task />
    </div>
</div>
@endsection
