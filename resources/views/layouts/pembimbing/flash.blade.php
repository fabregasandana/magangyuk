{{-- Flash message & validation errors untuk halaman pembimbing --}}
@if (session('success'))
    <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30">
        <i data-lucide="circle-check" class="w-5 h-5 text-emerald-400 shrink-0" aria-hidden="true"></i>
        <p class="text-sm font-semibold text-emerald-700">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30">
        <i data-lucide="circle-alert" class="w-5 h-5 text-rose-400 shrink-0" aria-hidden="true"></i>
        <p class="text-sm font-semibold text-rose-700">{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30">
        <div class="flex items-center gap-3">
            <i data-lucide="triangle-alert" class="w-5 h-5 text-rose-400 shrink-0" aria-hidden="true"></i>
            <p class="text-sm font-semibold text-rose-700">Mohon periksa kembali isian formulir:</p>
        </div>
        <ul class="mt-2 ml-8 list-disc text-xs text-rose-700/90 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
