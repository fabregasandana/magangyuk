@extends('layouts.admin')

@section('title', 'Fitur Pendukung Admin')

@section('content')
    @php
        // Peta status -> class Tailwind statis (tanpa perakitan class dinamis).
        $periodeBadges = [
            'Aktif' => ['class' => 'bg-emerald-500/15 text-emerald-400', 'dot' => 'bg-emerald-400'],
            'Selesai' => ['class' => 'bg-elevated text-muted', 'dot' => 'bg-slate-400'],
        ];
        $institusiBadges = [
            'aktif' => 'bg-emerald-500/15 text-emerald-400',
            'nonaktif' => 'bg-elevated text-muted',
        ];
        $aksiOptions = array_values(array_unique(array_column($logs, 'aksi')));
        sort($aksiOptions);
        $jumlahHalamanLog = max(1, (int) ceil($logMeta['total'] / $logMeta['ditampilkan']));
        $totalBobot = array_sum(array_column($pengaturan['bobot'], 'nilai'));
        $timeoutOptions = ['30 menit', '1 jam', '2 jam'];
        $keamanan = $pengaturan['keamanan'];
    @endphp

    <x-page-header eyebrow="Panel administrasi" title="Fitur Pendukung Admin" title-id="pageTitle" description="Periode, pengumuman, log aktivitas, dan pengaturan sistem">
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-foreground" id="current-date">&nbsp;</p>
                <p class="text-xs text-muted font-medium tabular-nums" id="current-time">&nbsp;</p>
            </div>
        </div>
    </x-page-header>

    <!-- Horizontal Tabs -->
    <div class="flex flex-wrap gap-2">
        <button type="button" data-action="switch-tab" data-group="fp" data-tab="periode"
            data-title="{{ $sectionTitles['periode'] }}"
            class="nav-tab active px-4 py-2 text-xs font-semibold rounded-xl border border-subtle text-foreground"><i data-lucide="calendar-days" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i> Periode Magang</button>
        <button type="button" data-action="switch-tab" data-group="fp" data-tab="institusi"
            data-title="{{ $sectionTitles['institusi'] }}"
            class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-subtle text-foreground"><i data-lucide="school" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i> Institusi</button>
        <button type="button" data-action="switch-tab" data-group="fp" data-tab="log"
            data-title="{{ $sectionTitles['log'] }}"
            class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-subtle text-foreground"><i data-lucide="clipboard-list" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i> Log Aktivitas</button>
        <button type="button" data-action="switch-tab" data-group="fp" data-tab="role"
            data-title="{{ $sectionTitles['role'] }}"
            class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-subtle text-foreground"><i data-lucide="key-round" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i> Role &amp; Permission</button>
        <button type="button" data-action="switch-tab" data-group="fp" data-tab="pengaturan"
            data-title="{{ $sectionTitles['pengaturan'] }}"
            class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-subtle text-foreground"><i data-lucide="settings" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i> Pengaturan</button>
    </div>

    <!-- ==================== SECTION: PERIODE ==================== -->
    <div id="sec-periode" data-panel="periode" data-group="fp" class="tab-panel active space-y-5">
        <div class="flex justify-end">
            <button type="button" data-action="open-modal" data-target="modalPeriode"
                data-modal-title="Buat Periode Baru"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm ui-button">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Buat Periode Baru</button>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card label="Total Periode" :value="$periodeStats['total']" icon="calendar-days" />
            <x-stat-card label="Periode Aktif" :value="$periodeStats['aktif']" icon="activity" />
            <x-stat-card label="Peserta Aktif" :value="$periodeStats['peserta']" icon="users" />
            <x-stat-card label="Progress" :value="$periodeStats['progress']" icon="trending-up" />
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle">
                <h3 class="text-base font-bold text-foreground">Daftar Periode Magang</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-subtle text-[11px] uppercase tracking-wider text-muted">
                            <th class="px-5 py-3.5 font-semibold">Nama Periode</th>
                            <th class="px-4 py-3.5 font-semibold">Mulai</th>
                            <th class="px-4 py-3.5 font-semibold">Selesai</th>
                            <th class="px-4 py-3.5 font-semibold text-center">Peserta</th>
                            <th class="px-4 py-3.5 font-semibold">Status</th>
                            <th class="px-4 py-3.5 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($periode as $pr)
                            @php $badge = $periodeBadges[$pr['status']] ?? $periodeBadges['Selesai']; @endphp
                            <tr class="table-row {{ $loop->last ? '' : 'border-b border-subtle' }}">
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-foreground">{{ $pr['nama'] }}</p>
                                    @if ($pr['status'] === 'Aktif')
                                        <div class="mt-1.5 w-32 h-1.5 bg-elevated rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full"
                                                style="width:{{ $pr['progress'] }}%"></div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-foreground">{{ $pr['mulai'] }}</td>
                                <td class="px-4 py-4 text-sm text-foreground">{{ $pr['selesai'] }}</td>
                                <td class="px-4 py-4 text-center text-sm font-semibold text-foreground">{{ $pr['peserta'] }}</td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $badge['class'] }} text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                        {{ $pr['status'] }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-center gap-1.5">
                                        <button type="button" data-action="open-modal" data-target="modalPeriode"
                                            data-modal-title="Edit Periode – {{ $pr['nama'] }}"
                                            data-form-fields='@json($pr['form'])' title="Edit periode"
                                            class="w-8 h-8 rounded-lg bg-surface hover:bg-komdigi-blue/20 flex items-center justify-center text-muted hover:text-komdigi-cerulean">
                                            <i data-lucide="square-pen" class="w-4 h-4" aria-hidden="true"></i>
                                        </button>
                                        <form action="{{ route('admin.feature.store') }}" method="POST" class="inline-flex">
                                            @csrf
                                            <input type="hidden" name="jenis" value="periode_status">
                                            <input type="hidden" name="id" value="{{ $pr['id'] }}">
                                            @if ($pr['status'] === 'Aktif')
                                                <button type="submit" title="Hentikan periode"
                                                    class="w-8 h-8 rounded-lg bg-surface hover:bg-amber-500/20 flex items-center justify-center text-muted hover:text-amber-400">
                                                    <i data-lucide="ban" class="w-4 h-4" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                <button type="submit" title="Aktifkan kembali periode"
                                                    class="w-8 h-8 rounded-lg bg-surface hover:bg-emerald-500/20 flex items-center justify-center text-muted hover:text-emerald-400">
                                                    <i data-lucide="circle-check" class="w-4 h-4" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <button type="button" data-action="open-modal" data-target="modalDelete"
                                            data-form-action="{{ route('admin.feature.delete') }}"
                                            data-form-fields='@json(['jenis' => 'periode', 'id' => $pr['id']])'
                                            data-modal-title="Hapus periode {{ $pr['nama'] }}?"
                                            data-modal-desc="Periode yang masih dipakai peserta tidak dapat dihapus."
                                            title="Hapus periode"
                                            class="w-8 h-8 rounded-lg bg-surface hover:bg-rose-500/20 flex items-center justify-center text-muted hover:text-rose-400">
                                            <i data-lucide="trash-2" class="w-4 h-4" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-muted">Belum ada data periode</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== SECTION: INSTITUSI ==================== -->
    <div id="sec-institusi" data-panel="institusi" data-group="fp" class="tab-panel space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" aria-hidden="true"></i>
                <input type="text" placeholder="Cari institusi..." aria-label="Cari institusi"
                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-surface border border-subtle rounded-xl text-foreground placeholder:text-muted focus:outline-none focus:border-komdigi-cerulean">
            </div>
            <button type="button" data-action="open-modal" data-target="modalInstitusi"
                data-modal-title="Tambah Institusi"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm ui-button">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Tambah Institusi</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse ($institusi as $ins)
                <div class="glass-card rounded-2xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $ins['gradient'] }} flex items-center justify-center text-white {{ strlen($ins['singkat']) > 4 ? 'text-xs' : 'text-sm' }} font-black">
                            {{ $ins['singkat'] }}</div>
                        <span
                            class="px-2 py-0.5 rounded-full {{ $institusiBadges[$ins['status']] ?? $institusiBadges['nonaktif'] }} text-[10px] font-bold">{{ ucfirst($ins['status']) }}</span>
                    </div>
                    <h3 class="text-sm font-bold text-foreground">{{ $ins['nama'] }}</h3>
                    <p class="text-xs text-muted mt-1">{{ $ins['jenis'] }} • {{ $ins['kota'] }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <p class="text-lg font-black {{ $ins['status'] === 'aktif' ? 'text-komdigi-cerulean' : 'text-muted' }}">
                                {{ $ins['peserta'] }}</p>
                            <p class="text-[10px] text-muted">Peserta</p>
                        </div>
                        <div class="flex gap-1.5">
                            <button type="button" data-action="open-modal" data-target="modalInstitusi"
                                data-modal-title="Edit Institusi – {{ $ins['nama'] }}"
                                data-form-fields='@json($ins['form'])' title="Edit institusi"
                                class="w-8 h-8 rounded-lg bg-surface hover:bg-komdigi-blue/20 flex items-center justify-center text-muted hover:text-komdigi-cerulean">
                                <i data-lucide="square-pen" class="w-4 h-4" aria-hidden="true"></i>
                            </button>
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.feature.delete') }}"
                                data-form-fields='@json(['jenis' => 'institusi', 'id' => $ins['id']])'
                                data-modal-title="Hapus {{ $ins['nama'] }}?"
                                data-modal-desc="Institusi yang masih dipakai peserta tidak dapat dihapus — nonaktifkan saja."
                                title="Hapus institusi"
                                class="w-8 h-8 rounded-lg bg-surface hover:bg-rose-500/20 flex items-center justify-center text-muted hover:text-rose-400">
                                <i data-lucide="trash-2" class="w-4 h-4" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-muted text-center py-8 md:col-span-2 xl:col-span-3">Belum ada data institusi</p>
            @endforelse
        </div>
    </div>

    <!-- ==================== SECTION: LOG AKTIVITAS ==================== -->
    <div id="sec-log" data-panel="log" data-group="fp" class="tab-panel space-y-5">
        <div class="glass-card rounded-2xl p-5">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" aria-hidden="true"></i>
                    <input type="text" placeholder="Cari aktivitas..." aria-label="Cari aktivitas"
                        data-action="filter-table" data-table="logTable" data-key="search"
                        class="w-full pl-10 pr-4 py-2.5 text-sm bg-surface border border-subtle rounded-xl text-foreground placeholder:text-muted focus:outline-none focus:border-komdigi-cerulean">
                </div>
                <select data-action="filter-table" data-table="logTable" data-key="aksi" aria-label="Filter aksi"
                    class="text-xs bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5">
                    <option value="">Semua Aksi</option>
                    @foreach ($aksiOptions as $aksi)
                        <option value="{{ strtolower($aksi) }}">{{ ucfirst(strtolower($aksi)) }}</option>
                    @endforeach
                </select>
                <select data-action="filter-table" data-table="logTable" data-key="role" aria-label="Filter role"
                    class="text-xs bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r['nama'] }}">{{ $r['nama'] }}</option>
                    @endforeach
                </select>
                <form action="{{ route('admin.feature.export-log') }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-foreground bg-surface border border-subtle rounded-xl hover:bg-elevated">
                        <i data-lucide="download" class="w-4 h-4" aria-hidden="true"></i> Export</button>
                </form>
            </div>
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left" id="logTable">
                    <thead>
                        <tr class="border-b border-subtle text-[11px] uppercase tracking-wider text-muted">
                            <th class="px-5 py-3.5 font-semibold">Waktu</th>
                            <th class="px-4 py-3.5 font-semibold">User</th>
                            <th class="px-4 py-3.5 font-semibold">Role</th>
                            <th class="px-4 py-3.5 font-semibold">Aksi</th>
                            <th class="px-4 py-3.5 font-semibold">Deskripsi</th>
                            <th class="px-4 py-3.5 font-semibold">IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="table-row {{ $loop->last ? '' : 'border-b border-subtle' }}" data-row
                                data-aksi="{{ strtolower($log['aksi']) }}" data-role="{{ $log['role'] }}">
                                <td class="px-5 py-3.5 text-xs text-muted whitespace-nowrap">{{ $log['waktu'] }}</td>
                                <td class="px-4 py-3.5 text-sm font-semibold text-foreground">{{ $log['user'] }}</td>
                                <td class="px-4 py-3.5 text-[11px] text-foreground">{{ $log['role'] }}</td>
                                <td class="px-4 py-3.5"><span
                                        class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $log['aksi_class'] }}">{{ $log['aksi'] }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-sm text-foreground">{{ $log['deskripsi'] }}</td>
                                <td class="px-4 py-3.5 text-xs text-muted font-mono">{{ $log['ip'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-muted">Belum ada log aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination (tampilan statis dari data controller) -->
            <div class="flex items-center justify-between px-5 py-4 border-t border-subtle">
                <p class="text-xs text-muted">Menampilkan 1–{{ $logMeta['ditampilkan'] }} dari
                    {{ number_format($logMeta['total'], 0, ',', '.') }} log</p>
                <div class="flex gap-1.5">
                    <button type="button" class="w-8 h-8 rounded-lg bg-surface text-muted text-xs font-bold"
                        aria-label="Halaman sebelumnya" disabled><i data-lucide="chevron-left" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i></button>
                    <button type="button"
                        class="w-8 h-8 rounded-lg bg-komdigi-blue text-white text-xs font-bold">1</button>
                    @if ($jumlahHalamanLog > 1)
                        <button type="button"
                            class="w-8 h-8 rounded-lg bg-surface text-muted text-xs font-bold hover:bg-elevated">2</button>
                        <button type="button" aria-label="Halaman berikutnya"
                            class="w-8 h-8 rounded-lg bg-surface text-muted text-xs font-bold hover:bg-elevated"><i data-lucide="chevron-right" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i></button>
                    @else
                        <button type="button" class="w-8 h-8 rounded-lg bg-surface text-muted text-xs font-bold"
                            aria-label="Halaman berikutnya" disabled><i data-lucide="chevron-right" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i></button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SECTION: ROLE & PERMISSION ==================== -->
    <div id="sec-role" data-panel="role" data-group="fp" class="tab-panel space-y-5">
        <div class="flex justify-end">
            <button type="button" data-action="open-modal" data-target="modalRole" data-modal-title="Tambah Role"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm ui-button">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Tambah Role</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($roles as $role)
                <div class="glass-card rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $role['gradient'] }} flex items-center justify-center text-white text-sm font-black">
                                {{ $role['initial'] }}</div>
                            <div>
                                <h3 class="text-base font-bold text-foreground">{{ $role['nama'] }}</h3>
                                <p class="text-[11px] text-muted">{{ $role['pengguna'] }} pengguna</p>
                            </div>
                        </div>
                        <button type="button" data-action="open-modal" data-target="modalRole"
                            data-modal-title="Edit Role – {{ $role['nama'] }}" data-form-fields='@json($role['form'])'
                            title="Edit role"
                            class="w-8 h-8 shrink-0 rounded-lg bg-surface hover:bg-komdigi-blue/20 flex items-center justify-center text-muted hover:text-komdigi-cerulean">
                            <i data-lucide="square-pen" class="w-4 h-4" aria-hidden="true"></i>
                        </button>
                    </div>
                    <p class="text-xs text-muted mb-3">{{ $role['deskripsi'] }}</p>
                    <span class="text-[11px] font-semibold text-komdigi-cerulean">{{ $role['permissions'] }} permissions</span>
                </div>
            @endforeach
        </div>
        <form method="POST" action="{{ route('admin.feature.store') }}">
            @csrf
            <input type="hidden" name="jenis" value="permission">
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-subtle flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-foreground">Matriks Permission</h3>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 text-sm ui-button">Simpan</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-subtle text-[11px] uppercase tracking-wider text-muted">
                                <th class="px-5 py-3.5 font-semibold">Permission</th>
                                <th class="px-4 py-3.5 font-semibold text-center">Admin</th>
                                <th class="px-4 py-3.5 font-semibold text-center">Pembimbing</th>
                                <th class="px-4 py-3.5 font-semibold text-center">Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissionMatrix as $gi => $grup)
                                <tr class="border-b border-subtle">
                                    <td colspan="4" class="px-5 py-2 bg-surface"><span
                                            class="text-[11px] font-bold text-komdigi-cerulean uppercase">{{ $grup['grup'] }}</span>
                                    </td>
                                </tr>
                                @foreach ($grup['items'] as $ii => $item)
                                    @php
                                        $isLastRow = $gi === array_key_last($permissionMatrix) && $ii === array_key_last($grup['items']);
                                    @endphp
                                    <tr class="table-row {{ $isLastRow ? '' : 'border-b border-subtle' }}">
                                        <td class="px-5 py-3 text-sm text-foreground">{{ $item['label'] }}</td>
                                        @foreach (['admin', 'pembimbing', 'peserta'] as $roleKey)
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox"
                                                    name="permission[{{ $gi }}][{{ $ii }}][{{ $roleKey }}]" value="1"
                                                    @checked(old('permission.' . $gi . '.' . $ii . '.' . $roleKey, $item[$roleKey]))
                                                    class="rounded border-subtle bg-surface text-komdigi-cerulean">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <!-- ==================== SECTION: PENGATURAN ==================== -->
    <div id="sec-pengaturan" data-panel="pengaturan" data-group="fp" class="tab-panel space-y-5">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="space-y-2">
                <button type="button" data-action="switch-tab" data-group="set" data-tab="bobot" id="stab-bobot"
                    class="set-tab active w-full text-left px-4 py-3 rounded-xl text-sm font-semibold text-foreground hover:bg-elevated flex items-center gap-3"><i data-lucide="star" class="w-4 h-4" aria-hidden="true"></i>
                    Bobot Penilaian</button>
                <button type="button" data-action="switch-tab" data-group="set" data-tab="notif" id="stab-notif"
                    class="set-tab w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-foreground hover:bg-elevated flex items-center gap-3"><i data-lucide="bell" class="w-4 h-4" aria-hidden="true"></i>
                    Notifikasi</button>
                <button type="button" data-action="switch-tab" data-group="set" data-tab="umum" id="stab-umum"
                    class="set-tab w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-foreground hover:bg-elevated flex items-center gap-3"><i data-lucide="settings" class="w-4 h-4" aria-hidden="true"></i>
                    Umum</button>
                <button type="button" data-action="switch-tab" data-group="set" data-tab="keamanan" id="stab-keamanan"
                    class="set-tab w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-foreground hover:bg-elevated flex items-center gap-3"><i data-lucide="lock-keyhole" class="w-4 h-4" aria-hidden="true"></i>
                    Keamanan</button>
            </div>
            <div class="xl:col-span-2">
                <div id="set-bobot" data-panel="bobot" data-group="set" class="set-panel">
                    <form method="POST" action="{{ route('admin.feature.store') }}"
                        class="glass-card rounded-2xl p-5 sm:p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="jenis" value="bobot">
                        <h3 class="text-base font-bold text-foreground">Bobot Penilaian Global</h3>
                        <div class="space-y-3">
                            @foreach ($pengaturan['bobot'] as $bi => $b)
                                <div class="flex items-center gap-4 p-3 rounded-2xl bg-surface border border-subtle">
                                    <p class="flex-1 text-sm font-semibold text-foreground">{{ $b['label'] }}</p>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="bobot[{{ $bi }}]" min="0" max="100"
                                            value="{{ old('bobot.' . $bi, $b['nilai']) }}"
                                            aria-label="Bobot {{ $b['label'] }}"
                                            class="w-16 text-center bg-surface border border-subtle text-foreground rounded-lg px-2 py-1.5 text-sm font-bold">
                                        <span class="text-sm text-muted">%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <p class="text-sm text-muted">Total: <span
                                    class="font-bold text-emerald-400">{{ $totalBobot }}%</span></p>
                            <button type="submit"
                                class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                        </div>
                    </form>
                </div>
                <div id="set-notif" data-panel="notif" data-group="set" class="set-panel hidden">
                    <form method="POST" action="{{ route('admin.feature.store') }}"
                        class="glass-card rounded-2xl p-5 sm:p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="jenis" value="notif">
                        <h3 class="text-base font-bold text-foreground">Pengaturan Notifikasi</h3>
                        <div class="space-y-3">
                            @foreach ($pengaturan['notif'] as $n)
                                <div
                                    class="flex items-center justify-between p-3 rounded-2xl bg-surface border border-subtle">
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">{{ $n['label'] }}</p>
                                        <p class="text-[11px] text-muted">{{ $n['deskripsi'] }}</p>
                                    </div>
                                    <label class="relative inline-flex cursor-pointer">
                                        <input type="checkbox" name="notif[{{ $n['key'] }}]" value="1"
                                            @checked(old('notif.' . $n['key'], $n['aktif'])) class="sr-only peer">
                                        <div
                                            class="w-10 h-5 bg-elevated rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean">
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                    </form>
                </div>
                <div id="set-umum" data-panel="umum" data-group="set" class="set-panel hidden">
                    <form method="POST" action="{{ route('admin.feature.store') }}"
                        class="glass-card rounded-2xl p-5 sm:p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="jenis" value="umum">
                        <h3 class="text-base font-bold text-foreground">Pengaturan Umum</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs text-muted mb-1.5" for="umumNamaSistem">Nama Sistem</label>
                                <input type="text" id="umumNamaSistem" name="nama_sistem"
                                    value="{{ old('nama_sistem', $pengaturan['nama_sistem']) }}"
                                    class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean">
                            </div>
                            <div>
                                <label class="block text-xs text-muted mb-1.5" for="umumEmail">Email Admin</label>
                                <input type="email" id="umumEmail" name="email_admin"
                                    value="{{ old('email_admin', $pengaturan['email_admin']) }}"
                                    class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-muted mb-1.5" for="umumMinSkor">Min. Skor
                                        Lulus</label>
                                    <input type="number" id="umumMinSkor" name="min_skor"
                                        value="{{ old('min_skor', $pengaturan['min_skor']) }}"
                                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-muted mb-1.5" for="umumMinKehadiran">Min. Kehadiran
                                        (%)</label>
                                    <input type="number" id="umumMinKehadiran" name="min_kehadiran"
                                        value="{{ old('min_kehadiran', $pengaturan['min_kehadiran']) }}"
                                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-muted mb-1.5" for="umumMaksPeserta">Maks. Peserta /
                                    Pembimbing</label>
                                <input type="number" id="umumMaksPeserta" name="maks_peserta_per_pembimbing"
                                    value="{{ old('maks_peserta_per_pembimbing', $pengaturan['maks_peserta_per_pembimbing']) }}"
                                    class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm">
                            </div>
                        </div>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                    </form>
                </div>
                <div id="set-keamanan" data-panel="keamanan" data-group="set" class="set-panel hidden">
                    <form method="POST" action="{{ route('admin.feature.store') }}"
                        class="glass-card rounded-2xl p-5 sm:p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="jenis" value="keamanan">
                        <h3 class="text-base font-bold text-foreground">Keamanan</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-surface border border-subtle">
                                <div>
                                    <p class="text-sm font-semibold text-foreground">{{ $keamanan[0]['label'] }}</p>
                                    <p class="text-[11px] text-muted">{{ $keamanan[0]['deskripsi'] }}</p>
                                </div>
                                <label class="relative inline-flex cursor-pointer">
                                    <input type="checkbox" name="keamanan[{{ $keamanan[0]['key'] }}]" value="1"
                                        @checked(old('keamanan.' . $keamanan[0]['key'], $keamanan[0]['aktif'])) class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-elevated rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-surface border border-subtle">
                                <div>
                                    <p class="text-sm font-semibold text-foreground">Session Timeout</p>
                                    <p class="text-[11px] text-muted">Logout otomatis</p>
                                </div>
                                <select name="session_timeout" aria-label="Session timeout"
                                    class="text-xs bg-surface border border-subtle text-foreground rounded-lg px-2 py-1.5">
                                    @foreach ($timeoutOptions as $opt)
                                        <option value="{{ $opt }}"
                                            @selected(old('session_timeout', $pengaturan['session_timeout']) === $opt)>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-surface border border-subtle">
                                <div>
                                    <p class="text-sm font-semibold text-foreground">{{ $keamanan[1]['label'] }}</p>
                                    <p class="text-[11px] text-muted">{{ $keamanan[1]['deskripsi'] }}</p>
                                </div>
                                <label class="relative inline-flex cursor-pointer">
                                    <input type="checkbox" name="keamanan[{{ $keamanan[1]['key'] }}]" value="1"
                                        @checked(old('keamanan.' . $keamanan[1]['key'], $keamanan[1]['aktif'])) class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-elevated rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL: Buat / Edit Periode -->
    <div id="modalPeriode" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalPeriode"></div>
        <div class="relative w-full max-w-lg glass-strong rounded-2xl p-6 space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-foreground" data-modal-title-slot>Buat Periode Baru</h3>
                <button type="button" data-action="close-modal" data-target="modalPeriode"
                    class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted">
                    <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                </button>
            </div>
            <form class="space-y-4" method="POST" action="{{ route('admin.feature.store') }}" data-modal-form>
                @csrf
                <input type="hidden" name="jenis" value="periode">
                <input type="hidden" name="id" value="">
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="periodeNama">Nama Periode</label>
                    <input type="text" id="periodeNama" name="nama" value="{{ old('nama') }}"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean"
                        placeholder="Magang Batch 2 - 2026" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-muted mb-1.5" for="periodeMulai">Tanggal Mulai</label>
                        <input type="date" id="periodeMulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                            class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs text-muted mb-1.5" for="periodeSelesai">Tanggal Selesai</label>
                        <input type="date" id="periodeSelesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                            class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="periodeMaks">Kuota Peserta</label>
                    <input type="number" id="periodeMaks" name="maks_peserta" min="1" max="10000"
                        value="{{ old('maks_peserta', 50) }}" placeholder="50"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm">
                    <p class="text-[11px] text-muted mt-1.5">Jumlah maksimum peserta yang diterima pada periode ini.</p>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="setAktif" name="set_aktif" value="1" @checked(old('set_aktif'))
                        class="rounded border-subtle bg-surface text-komdigi-cerulean">
                    <label for="setAktif" class="text-sm text-foreground">Jadikan aktif sekarang</label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" data-action="close-modal" data-target="modalPeriode"
                        class="px-4 py-2.5 text-sm font-semibold text-foreground bg-surface border border-subtle rounded-xl">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Institusi -->
    <div id="modalInstitusi" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalInstitusi"></div>
        <div class="relative w-full max-w-lg glass-strong rounded-2xl p-6 space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-foreground" data-modal-title-slot>Tambah Institusi</h3>
                <button type="button" data-action="close-modal" data-target="modalInstitusi"
                    class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted">
                    <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                </button>
            </div>
            <form class="space-y-4" method="POST" action="{{ route('admin.feature.store') }}" data-modal-form>
                @csrf
                <input type="hidden" name="jenis" value="institusi">
                <input type="hidden" name="id" value="">
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="institusiNama">Nama Institusi</label>
                    <input type="text" id="institusiNama" name="nama" value="{{ old('nama') }}"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean"
                        required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-muted mb-1.5" for="institusiSingkat">Singkatan</label>
                        <input type="text" id="institusiSingkat" name="singkat" value="{{ old('singkat') }}"
                            class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs text-muted mb-1.5" for="institusiJenis">Jenis</label>
                        <select id="institusiJenis" name="jenis_institusi" required
                            class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm">
                            @foreach ($jenisInstitusiOptions as $jenisIns)
                                <option value="{{ $jenisIns }}" @selected(old('jenis_institusi') === $jenisIns)>{{ $jenisIns }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="institusiKota">Kota</label>
                    <input type="text" id="institusiKota" name="kota" value="{{ old('kota') }}"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm"
                        placeholder="Medan">
                </div>
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="institusiStatus">Status</label>
                    <select id="institusiStatus" name="status" required
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm">
                        <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" data-action="close-modal" data-target="modalInstitusi"
                        class="px-4 py-2.5 text-sm font-semibold text-foreground bg-surface border border-subtle rounded-xl">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Role -->
    <div id="modalRole" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalRole"></div>
        <div class="relative w-full max-w-md glass-strong rounded-2xl p-6 space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-foreground" data-modal-title-slot>Tambah Role</h3>
                <button type="button" data-action="close-modal" data-target="modalRole"
                    class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted">
                    <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                </button>
            </div>
            <form class="space-y-4" method="POST" action="{{ route('admin.feature.store') }}" data-modal-form>
                @csrf
                <input type="hidden" name="jenis" value="role">
                <input type="hidden" name="id" value="">
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="roleNama">Nama Role</label>
                    <input type="text" id="roleNama" name="nama" value="{{ old('nama') }}"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean"
                        placeholder="Koordinator" required>
                </div>
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="roleSlug">Slug</label>
                    <input type="text" id="roleSlug" name="slug" value="{{ old('slug') }}"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm"
                        placeholder="koordinator">
                </div>
                <div>
                    <label class="block text-xs text-muted mb-1.5" for="roleDeskripsi">Deskripsi</label>
                    <textarea rows="2" id="roleDeskripsi" name="deskripsi"
                        class="w-full bg-surface border border-subtle text-foreground rounded-xl px-4 py-2.5 text-sm resize-none">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" data-action="close-modal" data-target="modalRole"
                        class="px-4 py-2.5 text-sm font-semibold text-foreground bg-surface border border-subtle rounded-xl">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm ui-button">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.admin.modal-delete', [
        'route' => route('admin.feature.delete'),
        'field' => 'id',
        'label' => 'data',
        'extra' => ['jenis' => ''],
    ])
@endpush
