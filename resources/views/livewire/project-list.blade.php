<div>
    <div class="mb-6">
        <div class="flex gap-4 items-center">
            <div class="w-64 relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search projects..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div class="w-48">
                <select wire:model.live="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-300 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100">
                        Project Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Description
                    </th>
                    <th wire:click="sortBy('status')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Tasks
                    </th>
                    <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100">
                        Created
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($projects as $project)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('tenant.projects.show', ['tenant' => $tenantId, 'project' => $project->id]) }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                {{ $project->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($project->description ?? 'No description', 50) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($project->status === 'active')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @elseif($project->status === 'completed')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Completed
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $project->tasks_count }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $project->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('tenant.projects.show', ['tenant' => $tenantId, 'project' => $project->id]) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('tenant.projects.edit', ['tenant' => $tenantId, 'project' => $project->id]) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button wire:click="deleteProject({{ $project->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer ce projet ?" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition" title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No projects found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($projects->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
