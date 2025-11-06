@extends('layouts.tenant')

@section('title', 'Modifier la tâche')

@section('content')
<div>
    <!-- Breadcrumbs and Back Link -->
    <div class="flex items-center justify-between mb-6">
        <x-breadcrumb :items="[
            ['label' => 'Accueil', 'url' => route('tenant.dashboard', ['tenant' => tenant('id')])],
            ['label' => 'Tâches', 'url' => route('tenant.tasks.index', ['tenant' => tenant('id')])],
            ['label' => 'Modifier']
        ]" />
        
        <a href="{{ route('tenant.tasks.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover whitespace-nowrap">
            ← Retour aux tâches
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-border p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier la tâche</h1>
                <p class="text-gray-600">Mettez à jour les informations de la tâche</p>
            </div>

            <livewire:edit-task :taskId="$task->id" />
        </div>
    </div>
</div>
@endsection
