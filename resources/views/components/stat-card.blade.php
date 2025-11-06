@props([
    'title',
    'value',
    'icon',
    'bgColor' => '#f3f4f6',
    'textColor' => 'text-gray-700',
    'iconColor' => 'text-gray-500',
])

<div class="rounded-lg shadow-md p-6 transition-transform hover:scale-105" style="background-color: {{ $bgColor }};">
    <div class="flex items-center justify-between">
        <div>
            <p class="font-semibold uppercase tracking-wide mb-2 {{ $textColor }}">
                {{ $title }}
            </p>
            <p class="text-3xl font-bold text-gray-800">{{ $value }}</p>
        </div>
        <div class="{{ $iconColor }}">
            {!! $icon !!}
        </div>
    </div>
</div>
