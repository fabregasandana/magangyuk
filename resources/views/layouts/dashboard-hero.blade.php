@php
    /** @var string $kicker */
    /** @var string $title */
    /** @var string $description */
    $meta = $meta ?? [];
    $mini = $mini ?? [];
    $actions = $actions ?? [];
@endphp
<section class="dash-hero" aria-labelledby="dash-hero-title">
    <div class="dash-hero-copy">
        <p class="dash-hero-kicker">{{ $kicker }}</p>
        <h1 id="dash-hero-title" data-split-text>{{ $title }}@if (!empty($accent)) <span class="dash-hero-accent">{{ $accent }}</span>@endif</h1>
        <p class="dash-hero-description">{{ $description }}</p>
        @if ($meta)
            <div class="dash-hero-meta">
                @foreach ($meta as $item)
                    <span class="dash-hero-chip">
                        <i data-lucide="{{ $item['icon'] ?? 'sparkles' }}" class="w-3.5 h-3.5" aria-hidden="true"></i>
                        {{ $item['label'] }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
    <div class="dash-hero-aside">
        @if ($actions)
            <div class="dash-hero-actions">
                @foreach ($actions as $action)
                    <a href="{{ $action['href'] }}" class="{{ ($action['variant'] ?? 'primary') === 'secondary' ? 'ui-button-secondary' : 'ui-button' }} inline-flex items-center justify-center gap-2 px-3.5 py-2.5 text-xs">
                        <i data-lucide="{{ $action['icon'] ?? 'arrow-right' }}" class="w-4 h-4" aria-hidden="true"></i>
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
        @if ($mini)
            <div class="dash-hero-mini">
                @foreach ($mini as $item)
                    <div class="dash-hero-mini-item">
                        <p class="dash-hero-mini-label">{{ $item['label'] }}</p>
                        <p class="dash-hero-mini-value">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
