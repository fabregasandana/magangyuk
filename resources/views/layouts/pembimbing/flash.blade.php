{{-- Flash message & validation errors untuk halaman pembimbing --}}
@if (session('success'))
    <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30">
        <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm font-semibold text-emerald-300">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30">
        <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm font-semibold text-rose-300">{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p class="text-sm font-semibold text-rose-300">Mohon periksa kembali isian formulir:</p>
        </div>
        <ul class="mt-2 ml-8 list-disc text-xs text-rose-300/90 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
