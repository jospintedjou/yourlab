<div>
    <form wire:submit="update">
        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre de la tâche</label>
            <input type="text" wire:model="title" id="title" 
                class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('title') border-red-500 @enderror">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea wire:model="description" id="description" rows="4" 
                class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('description') border-red-500 @enderror"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Project -->
        <div class="mb-6">
            <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">Projet</label>
            <select wire:model="project_id" id="project_id" 
                class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('project_id') border-red-500 @enderror">
                <option value="">Sélectionner un projet</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            @error('project_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
            <select wire:model="status" id="status" 
                class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('status') border-red-500 @enderror">
                <option value="todo">À faire</option>
                <option value="in_progress">En cours</option>
                <option value="done">Terminée</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Priority -->
        <div class="mb-6">
            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
            <select wire:model="priority" id="priority" 
                class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('priority') border-red-500 @enderror">
                <option value="low">Basse</option>
                <option value="medium">Moyenne</option>
                <option value="high">Haute</option>
            </select>
            @error('priority')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Due Date -->
        <div class="mb-6">
            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Date d'échéance (Optionnel)</label>
            <input type="date" wire:model="due_date" id="due_date" 
                class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('due_date') border-red-500 @enderror">
            @error('due_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-hover transition">
                Mettre à jour la tâche
            </button>
            <a href="{{ route('tenant.tasks.index', ['tenant' => $tenantId]) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
