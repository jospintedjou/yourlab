@extends('layouts.tenant')

@section('title', 'Tasks')

@section('content')
<div>
    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tasks</h1>
            <p class="text-gray-600">Manage all tasks across projects</p>
        </div>
        <a href="{{ route('tenant.tasks.create', ['tenant' => tenant('id')]) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Task
        </a>
    </div>

    <livewire:task-list />
</div>
@endsection
