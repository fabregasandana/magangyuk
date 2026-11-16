@props(['label', 'value', 'icon' => 'activity', 'caption' => null])

{{-- Same structure as the dashboard stat cards: label, icon, value, optional caption. --}}
<div {{ $attributes->merge(['class' => 'glass-card ui-stat rounded-2xl p-4']) }}>
    <div class="flex items-start justify-between gap-3">
        <p class="text-sm font-medium text-muted">{{ $label }}</p>
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
        @endif
    </div>
    <p class="ui-stat-value mt-3 text-3xl font-semibold tabular-nums"><span data-counter="{{ $value }}">{{ $value }}</span></p>
    @if ($caption !== null)
        <p class="mt-2 text-xs leading-relaxed text-muted">{{ $caption }}</p>
    @endif
</div>
