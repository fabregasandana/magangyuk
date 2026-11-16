@props(['eyebrow' => null, 'title', 'description' => null, 'titleId' => null])

{{-- One header structure for every dashboard page: eyebrow, title, description, optional actions. --}}
<header {{ $attributes->merge(['class' => 'ui-page-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }} data-reveal>
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="ui-eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1 @if ($titleId) id="{{ $titleId }}" @endif class="mt-2 text-2xl font-semibold tracking-tight text-foreground sm:text-3xl break-words">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-sm text-muted">{{ $description }}</p>
        @endif
    </div>
    @if (! $slot->isEmpty())
        <div class="flex flex-wrap items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</header>
