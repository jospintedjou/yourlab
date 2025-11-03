@extends('layouts.app')

@section('title', 'My Organizations')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Organizations</h1>
        <a href="{{ route('organizations.create') }}" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-hover">
            + Create New Organization
        </a>
    </div>

    @if($tenants->isEmpty())
        <div class="bg-white rounded-lg shadow-sm border border-border p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No organizations yet</h3>
            <p class="mt-2 text-sm text-gray-500">Get started by creating your first organization.</p>
            <div class="mt-6">
                <a href="{{ route('organizations.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-hover">
                    Create Organization
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tenants as $tenant)
                <div class="bg-white rounded-lg shadow-sm border border-border p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $tenant->name }}</h3>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $tenant->pivot->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($tenant->pivot->role) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Organization ID: {{ $tenant->id }}</p>
                    <a href="{{ route('organizations.switch', ['tenant' => $tenant->id]) }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Open Dashboard
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
