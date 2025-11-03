@extends('layouts.tenant')

@section('title', 'Edit Project')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-6">
        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="text-primary hover:text-primary-hover">
            ← Back to Projects
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Project</h1>

        <livewire:edit-project :projectId="$project->id" />
    </div>
</div>
@endsection
