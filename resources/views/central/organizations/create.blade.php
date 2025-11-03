@extends('layouts.app')

@section('title', 'Create Organization')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Create New Organization</h1>

    <div class="bg-white rounded-lg shadow-sm border border-border p-8">
        <form method="POST" action="{{ route('organizations.store') }}">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Organization Name</label>
                <input type="text" name="name" id="name" required 
                    class="w-full px-4 py-2 border border-border rounded-md focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Enter organization name" value="{{ old('name') }}">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('organizations.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-hover">
                    Create Organization
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
