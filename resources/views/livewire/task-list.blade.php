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
                    placeholder="Search tasks..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div class="w-40">
                <select wire:model.live="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="todo">To Do</option>
                    <option value="in_progress">In Progress</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="w-40">
                <select wire:model.live="priorityFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-300 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('title')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100">
                        Task Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Project
                    </th>
                    <th wire:click="sortBy('status')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100">
                        Status
                    </th>
                    <th wire:click="sortBy('priority')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100">
                        Priority
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Due Date
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('tenant.tasks.show', ['tenant' => $tenantId, 'task' => $task->id]) }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <div>
                                    {{ $task->title }}
                                    @if($task->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($task->description, 50) }}</p>
                                    @endif
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $task->project->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($task->status === 'done')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Done
                                </span>
                            @elseif($task->status === 'in_progress')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    In Progress
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    To Do
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($task->priority === 'high')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    High
                                </span>
                            @elseif($task->priority === 'medium')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Medium
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Low
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($task->due_date)
                                {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('tenant.tasks.show', ['tenant' => $tenantId, 'task' => $task->id]) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('tenant.tasks.edit', ['tenant' => $tenantId, 'task' => $task->id]) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette tâche ?" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition" title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No tasks found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($tasks->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
