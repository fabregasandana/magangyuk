{{-- Flash message & validation errors untuk halaman peserta --}}
@php
    $flashTypes = [
        'success' => ['label' => 'Berhasil', 'box' => 'bg-emerald-500/20 border-emerald-500/40', 'text' => 'text-emerald-200'],
        'info' => ['label' => 'Info', 'box' => 'bg-sky-500/20 border-sky-500/40', 'text' => 'text-sky-200'],
        'error' => ['label' => 'Gagal', 'box' => 'bg-rose-500/20 border-rose-500/40', 'text' => 'text-rose-200'],
    ];
@endphp

@foreach ($flashTypes as $key => $style)
    @if (session($key))
        <div data-flash-dismiss="6000"
            class="mb-4 flex items-start gap-3 rounded-2xl border px-4 py-3 backdrop-blur-md {{ $style['box'] }}">
            <span class="text-xs font-black uppercase tracking-wide {{ $style['text'] }}">{{ $style['label'] }}</span>
            <p class="text-sm font-medium text-white">{{ session($key) }}</p>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="mb-4 rounded-2xl border border-rose-500/40 bg-rose-500/20 px-4 py-3 backdrop-blur-md">
        <p class="text-xs font-black uppercase tracking-wide text-rose-200">Periksa kembali isian Anda</p>
        <ul class="mt-1 list-inside list-disc text-sm font-medium text-white">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
