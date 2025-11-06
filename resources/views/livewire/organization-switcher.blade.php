<div class="relative" x-data="{ isOpen: false }">
    <button @click="isOpen = !isOpen" class="flex items-center space-x-2 px-3 py-2 text-sm border border-border rounded hover:bg-gray-50">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
        <span>Changer d'organisation</span>
    </button>

    <div x-show="isOpen" @click.away="isOpen = false" x-cloak class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-border z-50">
        <div class="py-2">
            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Vos organisations</div>
            @forelse($organizations as $org)
                <a wire:navigate href="{{ route('tenant.dashboard', ['tenant' => $org->id]) }}" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex items-center justify-between block">
                    <span class="text-sm text-gray-700">{{ $org->name }}</span>
                    @if(tenancy()->initialized && tenant('id') === $org->id)
                        <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </a>
            @empty
                <div class="px-4 py-2 text-sm text-gray-500">Aucune organisation trouvée</div>
            @endforelse
            
            <div class="border-t border-border mt-2 pt-2">
                <a href="{{ route('organizations.create') }}" class="block px-4 py-2 text-sm text-primary hover:bg-gray-50">
                    + Créer une nouvelle organisation
                </a>
            </div>
        </div>
    </div>
</div>
