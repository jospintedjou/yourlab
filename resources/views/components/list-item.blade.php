@props([
    'title',
    'subtitle',
    'status',
    'icon' => null,
])

<div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded transition">
    <!-- Icon -->
    <div class="flex-shrink-0">
        @if($icon)
            {!! $icon !!}
        @else
            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
        @endif
    </div>
    
    <!-- Content -->
    <div class="flex-1 min-w-0">
        <p class="font-medium text-gray-900 truncate">{{ $title }}</p>
        <p class="text-sm text-gray-600 truncate">{{ $subtitle }}</p>
    </div>
    
    <!-- Status Badge -->
    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $status->color() }}-100 text-{{ $status->color() }}-800 whitespace-nowrap">
        {{ $status->label() }}
    </span>
</div>
