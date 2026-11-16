@extends('layouts.pembimbing')

@section('title', 'Approval Logbook')

@section('content')

    <x-page-header eyebrow="Review & persetujuan" title="Approval Logbook" description="Tinjau dan setujui logbook peserta bimbingan">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-xs font-bold text-amber-700">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            {{ $jumlahPending }} Menunggu
        </div>
    </x-page-header>

    {{-- Filters --}}
    <div class="glass-card rounded-2xl p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" aria-hidden="true"></i>
                <input type="text" id="searchLogbook" placeholder="Cari nama peserta..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-surface border border-subtle rounded-xl text-foreground placeholder:text-muted focus:outline-none focus:border-komdigi-cerulean">
            </div>
            <select id="filterPeserta" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                <option value="all">Semua Peserta</option>
                @foreach ($opsiPeserta as $opsi)
                    <option value="{{ $opsi['key'] }}">{{ $opsi['nama'] }}</option>
                @endforeach
            </select>
            <select id="filterTanggal" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                <option value="all">Semua Tanggal</option>
                @foreach ($opsiMinggu as $minggu)
                    <option value="{{ $minggu['value'] }}">{{ $minggu['label'] }}</option>
                @endforeach
            </select>
            <select id="filterStatusLogbook" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                <option value="pending">Menunggu</option>
                <option value="all">Semua Status</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
    </div>

    {{-- Split: List + Preview --}}
    <div class="grid lg:grid-cols-5 gap-5">

        {{-- LEFT: List Logbook --}}
        <div class="lg:col-span-2 space-y-3">
            <p class="text-xs font-bold text-muted uppercase tracking-wider px-1">Daftar Logbook</p>

            @forelse ($logbook as $lb)
                <div class="logbook-item glass-card rounded-2xl p-4 {{ $loop->first ? 'active' : '' }}"
                    data-id="{{ $lb['id'] }}"
                    data-peserta="{{ $lb['peserta_key'] }}"
                    data-minggu="{{ $lb['minggu_key'] }}"
                    data-status="pending"
                    data-nama="{{ $lb['peserta_nama'] }}"
                    data-meta="{{ $lb['peserta_nama'] }} • {{ $lb['minggu_label'] }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $lb['avatar'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $lb['peserta_inisial'] }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-bold text-foreground truncate">{{ $lb['peserta_nama'] }}</p>
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold shrink-0">Menunggu</span>
                            </div>
                            <p class="text-xs text-muted mt-0.5">{{ $lb['minggu_label'] }} • {{ $lb['rentang'] }}</p>
                            <p class="text-[11px] text-muted mt-1 truncate">Dikirim: {{ $lb['dikirim'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-muted px-1">Tidak ada logbook yang menunggu approval.</p>
            @endforelse

            <p id="logbookEmpty" class="hidden text-sm text-muted px-1">Tidak ada logbook yang cocok dengan pencarian/filter.</p>
        </div>

        {{-- RIGHT: Preview + Action --}}
        <div class="lg:col-span-3">
            <div class="glass-card rounded-2xl overflow-hidden sticky top-[100px]">
                <div class="px-5 py-4 border-b border-subtle flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-foreground text-base">Preview Logbook</h3>
                        <p class="text-xs text-muted mt-0.5" id="previewMeta">{{ ($logbook[0]['peserta_nama'] ?? '') }} • {{ ($logbook[0]['minggu_label'] ?? '') }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold">Menunggu Approval</span>
                </div>

                <div class="p-5 preview-panel space-y-5" id="previewContent">
                    @foreach ($logbook as $lb)
                        <div class="space-y-5 {{ $loop->first ? '' : 'hidden' }}" data-preview-for="{{ $lb['id'] }}">
                            {{-- Info --}}
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="bg-surface rounded-xl px-4 py-3 border border-subtle">
                                    <p class="text-[10px] font-bold text-muted uppercase">Peserta</p>
                                    <p class="text-sm font-semibold text-foreground mt-0.5">{{ $lb['peserta_nama'] }}</p>
                                    <p class="text-[11px] text-muted">{{ $lb['peserta_id'] }}</p>
                                </div>
                                <div class="bg-surface rounded-xl px-4 py-3 border border-subtle">
                                    <p class="text-[10px] font-bold text-muted uppercase">Periode</p>
                                    <p class="text-sm font-semibold text-foreground mt-0.5">{{ $lb['minggu_label'] }}</p>
                                    <p class="text-[11px] text-muted">{{ $lb['rentang_panjang'] }}</p>
                                </div>
                            </div>

                            {{-- Kegiatan --}}
                            <div>
                                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-2">Uraian Kegiatan</p>
                                <div class="bg-surface rounded-xl p-4 border border-subtle text-sm text-foreground leading-relaxed space-y-3">
                                    <p>{{ $lb['uraian'] }}</p>
                                    <ul class="list-disc list-inside space-y-1.5 text-foreground">
                                        @foreach ($lb['kegiatan'] as $kegiatan)
                                            <li>{{ $kegiatan }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            {{-- Hasil / Output --}}
                            <div>
                                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-2">Hasil / Output</p>
                                <div class="bg-surface rounded-xl p-4 border border-subtle text-sm text-foreground leading-relaxed">
                                    <p>{{ $lb['hasil'] }}</p>
                                </div>
                            </div>

                            {{-- Kendala --}}
                            <div>
                                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-2">Kendala</p>
                                <div class="bg-surface rounded-xl p-4 border border-subtle text-sm text-foreground leading-relaxed">
                                    <p>{{ $lb['kendala'] }}</p>
                                </div>
                            </div>

                            {{-- Rencana Minggu Depan --}}
                            <div>
                                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-2">Rencana Minggu Depan</p>
                                <div class="bg-surface rounded-xl p-4 border border-subtle text-sm text-foreground leading-relaxed">
                                    <ul class="list-disc list-inside space-y-1.5 text-foreground">
                                        @foreach ($lb['rencana'] as $rencana)
                                            <li>{{ $rencana }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Action Area --}}
                <form method="POST" action="{{ route('pembimbing.logbook.review') }}" class="px-5 py-4 border-t border-subtle space-y-3 bg-surface">
                    @csrf
                    <input type="hidden" name="logbook_id" id="logbookIdInput" value="{{ $logbook[0]['id'] ?? '' }}">
                    <div>
                        <label for="komentar" class="form-label">Komentar Pembimbing</label>
                        <textarea id="komentar" name="komentar" rows="3" placeholder="Tulis komentar atau catatan untuk peserta (opsional)..." class="form-input">{{ old('komentar') }}</textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2.5">
                        <button type="submit" name="keputusan" value="approve" class="ui-button ui-button-success flex-1">
                            <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i>
                            Setujui Logbook
                        </button>
                        <button type="submit" name="keputusan" value="reject" class="ui-button ui-button-danger flex-1">
                            <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                            Tolak Logbook
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
