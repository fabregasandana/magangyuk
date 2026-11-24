@php
    $quickActions = match ($role) {
        'peserta' => [
            ['Absen sekarang', 'scan-face', route('peserta.absensi')],
            ['Isi logbook', 'notebook-pen', route('peserta.laporan')],
            ['Ajukan izin', 'calendar-off', route('peserta.izin')],
            ['Lihat sertifikat', 'award', route('peserta.sertifikat')],
        ],
        'pembimbing' => [
            ['Review logbook', 'book-open-check', route('pembimbing.logbook')],
            ['Nilai peserta', 'star', route('pembimbing.penilaianpeserta')],
            ['Daftar peserta', 'users-round', route('pembimbing.peserta')],
            ['Laporan bimbingan', 'chart-column', route('pembimbing.laporanbimbingan')],
        ],
        default => [
            ['Monitoring kinerja', 'chart-no-axes-combined', route('admin.monitoring')],
            ['Manajemen peserta', 'users-round', route('admin.manajemen-peserta')],
            ['Kelola penilaian', 'clipboard-check', route('admin.kelola-penilaian')],
            ['CMS konten', 'panels-top-left', route('admin.cms')],
        ],
    };
@endphp

<div class="quick-actions" aria-label="Aksi cepat">
    <button type="button" class="quick-actions-fab" @click="quickOpen = !quickOpen" :aria-expanded="quickOpen ? 'true' : 'false'" aria-controls="quick-actions-panel">
        <i data-lucide="zap" class="w-4 h-4" aria-hidden="true"></i>
        <span>Aksi cepat</span>
    </button>
    <div id="quick-actions-panel" class="popover quick-actions-popover" x-show="quickOpen" x-cloak x-transition.origin.bottom.right @click.outside="quickOpen = false" role="menu" aria-label="Aksi cepat">
        <div class="popover-head">
            <p class="popover-title">Aksi cepat</p>
            <span class="chip">{{ ucfirst($role) }}</span>
        </div>
        <div class="popover-body">
            @foreach ($quickActions as [$label, $icon, $href])
                <a href="{{ $href }}" class="popover-item" role="menuitem">
                    <span class="popover-item-icon"><i data-lucide="{{ $icon }}" class="w-4 h-4" aria-hidden="true"></i></span>
                    <span class="popover-item-title">{{ $label }}</span>
                    <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 ml-auto shrink-0 text-muted" aria-hidden="true"></i>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="command-backdrop" x-show="commandOpen" x-cloak @click.self="closeCommand()" role="dialog" aria-modal="true" aria-labelledby="command-heading">
    <div class="command-panel" x-transition>
        <div class="command-input-row">
            <i data-lucide="search" class="w-4 h-4 text-muted" aria-hidden="true"></i>
            <h2 id="command-heading" class="sr-only">Cari halaman</h2>
            <input
                type="search"
                class="command-input"
                x-ref="commandInput"
                x-model="query"
                @keydown.arrow-down.prevent="move(1)"
                @keydown.arrow-up.prevent="move(-1)"
                @keydown.enter.prevent="runActive()"
                placeholder="Cari halaman, menu, atau aksi…"
                aria-label="Cari halaman"
                autocomplete="off"
            >
            <kbd class="command-item-hint">Esc</kbd>
        </div>
        <div class="command-list" role="listbox" aria-label="Hasil pencarian">
            <template x-for="(item, index) in filtered" :key="item.href">
                <a :href="item.href" class="command-item" :class="{ 'is-active': index === activeIndex }" role="option" :aria-selected="index === activeIndex ? 'true' : 'false'">
                    <span class="command-item-icon" x-text="item.label.charAt(0).toUpperCase()" aria-hidden="true"></span>
                    <span class="command-item-label" x-text="item.label"></span>
                    <span class="command-item-hint">Buka</span>
                </a>
            </template>
            <p class="popover-empty" x-show="!filtered.length">
                Tidak ada halaman yang cocok dengan “<span x-text="query"></span>”.
            </p>
        </div>
        <div class="command-foot">
            <span><kbd>↑</kbd><kbd>↓</kbd> jelajahi</span>
            <span><kbd>Enter</kbd> buka</span>
            <span><kbd>Esc</kbd> tutup</span>
            <span class="ml-auto">{{ $role === 'admin' ? 'Admin' : ucfirst($role) }} workspace</span>
        </div>
    </div>
</div>

<div class="toast-stack" aria-live="polite" aria-atomic="false">
    <template x-for="toast in $store.toasts.items" :key="toast.id">
        <div class="toast-item" :data-type="toast.type" x-transition>
            <span class="mt-1 h-2 w-2 shrink-0 rounded-full" :style="toast.type === 'success' ? 'background:var(--ui-success)' : 'background:var(--ui-primary)'" aria-hidden="true"></span>
            <p class="min-w-0 flex-1 text-sm" x-text="toast.message"></p>
            <button type="button" class="text-muted hover:text-foreground" @click="$store.toasts.dismiss(toast.id)" aria-label="Tutup notifikasi">
                <span aria-hidden="true" class="text-base leading-none">&times;</span>
            </button>
        </div>
    </template>
</div>
