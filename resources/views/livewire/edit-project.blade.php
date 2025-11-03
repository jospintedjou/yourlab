<div>
    <form wire:submit="update">
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Project Name *</label>
            <input type="text" wire:model="name" id="name" 
                class="w-full px-4 py-2 border border-border rounded-md focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea wire:model="description" id="description" rows="4" 
                class="w-full px-4 py-2 border border-border rounded-md focus:ring-2 focus:ring-primary @error('description') border-red-500 @enderror"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" wire:model="start_date" id="start_date" 
                    class="w-full px-4 py-2 border border-border rounded-md focus:ring-2 focus:ring-primary @error('start_date') border-red-500 @enderror">
                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" wire:model="end_date" id="end_date" 
                    class="w-full px-4 py-2 border border-border rounded-md focus:ring-2 focus:ring-primary @error('end_date') border-red-500 @enderror">
                @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
            <select wire:model="status" id="status" 
                class="w-full px-4 py-2 border border-border rounded-md focus:ring-2 focus:ring-primary @error('status') border-red-500 @enderror">
                <option value="draft">Draft</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('tenant.projects.index', ['tenant' => $tenantId]) }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-hover">
                Update Project
            </button>
        </div>
    </form>
</div>
