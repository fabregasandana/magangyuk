{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.dashboardAdmin')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-blue-100/80 font-medium">Panel Administrasi</p>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Dashboard Admin</h1>
        </div>
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-white" id="current-date">Senin, 9 November 2026</p>
                <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">10.45.00 WIB</p>
            </div>
        </div>
    </div>

    {{-- Statistik Keseluruhan --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Peserta Aktif --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-komdigi-cerulean/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md">+12 bulan ini</span>
            </div>
            <p class="text-2xl font-black text-white">{{ $stats['total_peserta_aktif'] ?? 248 }}</p>
            <p class="text-xs text-slate-400 mt-1">Total Peserta Aktif</p>
        </div>

        {{-- Rata-rata Kehadiran --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-emerald-400">{{ $stats['rata_kehadiran'] ?? '92.4' }}%</p>
            <p class="text-xs text-slate-400 mt-1">Rata-rata Kehadiran</p>
        </div>

        {{-- Rata-rata Skor --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-amber-400">{{ $stats['rata_skor'] ?? '83.7' }}</p>
            <p class="text-xs text-slate-400 mt-1">Rata-rata Skor Kinerja</p>
        </div>

        {{-- Logbook Menunggu Approval --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @if(($stats['logbook_pending'] ?? 47) > 0)
                    <span class="text-[10px] font-semibold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-md animate-pulse">Perlu aksi</span>
                @endif
            </div>
            <p class="text-2xl font-black text-rose-400">{{ $stats['logbook_pending'] ?? 47 }}</p>
            <p class="text-xs text-slate-400 mt-1">Logbook Menunggu Approval</p>
        </div>
    </div>

    {{-- Grafik Tren --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Tren per Periode --}}
        <div class="glass-card rounded-3xl p-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-white">Tren Magang per Periode</h3>
                <select class="text-xs bg-white/5 border border-white/10 text-slate-300 rounded-lg px-2 py-1.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option>2026</option>
                    <option>2025</option>
                </select>
            </div>
            <div class="h-56">
                <canvas id="trendPeriodeChart"></canvas>
            </div>
        </div>

        {{-- Tren per Institusi --}}
        <div class="glass-card rounded-3xl p-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-white">Distribusi Peserta per Institusi</h3>
            </div>
            <div class="h-56">
                <canvas id="institusiChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Two Column: Low Performance + Notifications --}}
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-5">

        {{-- Daftar Peserta Performa Rendah --}}
        <div class="xl:col-span-3 glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/8 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-white">Peserta Performa Rendah</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Skor &lt; 75 atau kehadiran &lt; 80%</p>
                </div>
                <a href="" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/8 text-[11px] uppercase tracking-wider text-slate-400">
                            <th class="px-5 py-3 font-semibold">Peserta</th>
                            <th class="px-4 py-3 font-semibold text-center">Skor</th>
                            <th class="px-4 py-3 font-semibold text-center">Kehadiran</th>
                            <th class="px-4 py-3 font-semibold">Pembimbing</th>
                            <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowPerformers ?? [
                            ['nama' => 'Rizky Fauzan', 'id' => 'MKD-2026-0755', 'skor' => 74, 'hadir' => 72, 'pembimbing' => 'Budi Santoso', 'initial' => 'RF', 'color' => 'from-amber-500 to-orange-400'],
                            ['nama' => 'Ahmad Syahputra', 'id' => 'MKD-2026-0798', 'skor' => 71, 'hadir' => 68, 'pembimbing' => 'Budi Santoso', 'initial' => 'AS', 'color' => 'from-orange-500 to-red-400'],
                            ['nama' => 'Siti Aisyah', 'id' => 'MKD-2026-0812', 'skor' => 69, 'hadir' => 75, 'pembimbing' => 'Sari Dewi', 'initial' => 'SA', 'color' => 'from-rose-500 to-pink-400'],
                            ['nama' => 'Dimas Pratama', 'id' => 'MKD-2026-0834', 'skor' => 73, 'hadir' => 70, 'pembimbing' => 'Ahmad Fauzi', 'initial' => 'DP', 'color' => 'from-violet-500 to-purple-400'],
                        ] as $p)
                        <tr class="table-row border-b border-white/5">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $p['color'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['initial'] }}</div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $p['nama'] }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $p['id'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-sm font-black {{ $p['skor'] < 70 ? 'text-rose-400' : 'text-amber-400' }}">{{ $p['skor'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-sm font-semibold {{ $p['hadir'] < 75 ? 'text-rose-400' : 'text-amber-400' }}">{{ $p['hadir'] }}%</span>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-slate-300">{{ $p['pembimbing'] }}</td>
                            <td class="px-4 py-3.5 text-center">
                                <a href="#" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-400">Tidak ada peserta dengan performa rendah</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Notifikasi Penting Sistem --}}
        <div class="xl:col-span-2 glass-card rounded-3xl p-5 sm:p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-base font-bold text-white">Notifikasi Penting</h3>
            </div>
            <div class="space-y-3">
                @foreach($notifications ?? [
                    ['type' => 'danger', 'title' => '47 Logbook menunggu approval', 'desc' => 'Beberapa pembimbing belum meninjau logbook minggu ini', 'time' => '2 jam lalu'],
                    ['type' => 'warning', 'title' => '4 peserta skor di bawah 75', 'desc' => 'Perlu monitoring dan tindakan pembimbing', 'time' => '5 jam lalu'],
                    ['type' => 'info', 'title' => 'Periode magang 55% berjalan', 'desc' => 'Sisa 5 minggu hingga akhir periode Desember', 'time' => '1 hari lalu'],
                    ['type' => 'success', 'title' => '12 pendaftaran baru disetujui', 'desc' => 'Peserta baru dari USU dan UNIMED', 'time' => '2 hari lalu'],
                ] as $n)
                <div class="p-3.5 rounded-2xl bg-white/[0.03] border border-white/8 hover:border-white/15 transition">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full mt-1.5 shrink-0
                            {{ $n['type'] === 'danger' ? 'bg-rose-400' : '' }}
                            {{ $n['type'] === 'warning' ? 'bg-amber-400' : '' }}
                            {{ $n['type'] === 'info' ? 'bg-komdigi-cerulean' : '' }}
                            {{ $n['type'] === 'success' ? 'bg-emerald-400' : '' }}
                        "></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white leading-snug">{{ $n['title'] }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5 leading-relaxed">{{ $n['desc'] }}</p>
                            <p class="text-[10px] text-slate-500 mt-1.5">{{ $n['time'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Ringkasan Aktivitas Terbaru --}}
    <div class="glass-card rounded-3xl p-5 sm:p-6">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-white">Ringkasan Aktivitas Terbaru</h3>
            </div>
            <a href="#" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Lihat semua aktivitas</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Logbook Activity --}}
            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                <p class="text-xs font-semibold text-komdigi-cerulean uppercase tracking-wide mb-3">Logbook</p>
                <div class="space-y-2.5">
                    @foreach($recentLogbook ?? [
                        ['user' => 'Salwa Rameyza', 'action' => 'mengirim logbook minggu ke-5', 'time' => '10 menit lalu'],
                        ['user' => 'Nadia Putri', 'action' => 'logbook disetujui pembimbing', 'time' => '45 menit lalu'],
                        ['user' => 'Rizky Fauzan', 'action' => 'logbook ditolak — perlu revisi', 'time' => '2 jam lalu'],
                    ] as $item)
                    <div class="flex gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-komdigi-cerulean mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-xs text-white"><span class="font-semibold">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                            <p class="text-[10px] text-slate-500">{{ $item['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Penilaian Activity --}}
            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide mb-3">Penilaian</p>
                <div class="space-y-2.5">
                    @foreach($recentPenilaian ?? [
                        ['user' => 'Budi Santoso', 'action' => 'menilai Salwa Rameyza (skor 88)', 'time' => '1 jam lalu'],
                        ['user' => 'Sari Dewi', 'action' => 'menilai Fajar Aditya (skor 90)', 'time' => '3 jam lalu'],
                        ['user' => 'Ahmad Fauzi', 'action' => 'menilai Maya Lestari (skor 87)', 'time' => '5 jam lalu'],
                    ] as $item)
                    <div class="flex gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-amber-400 mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-xs text-white"><span class="font-semibold">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                            <p class="text-[10px] text-slate-500">{{ $item['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Pendaftaran Baru --}}
            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wide mb-3">Pendaftaran Baru</p>
                <div class="space-y-2.5">
                    @foreach($recentPendaftaran ?? [
                        ['user' => 'Lina Marlina', 'action' => 'mendaftar — USU, diterima', 'time' => '3 jam lalu'],
                        ['user' => 'Rendi Saputra', 'action' => 'mendaftar — UNIMED, menunggu', 'time' => '6 jam lalu'],
                        ['user' => 'Putri Anggraini', 'action' => 'mendaftar — POLMED, diterima', 'time' => '1 hari lalu'],
                    ] as $item)
                    <div class="flex gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-xs text-white"><span class="font-semibold">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                            <p class="text-[10px] text-slate-500">{{ $item['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Tren per Periode
    new Chart(document.getElementById('trendPeriodeChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5', 'Minggu 6'],
            datasets: [
                {
                    label: 'Peserta Aktif',
                    data: [210, 225, 238, 242, 245, 248],
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.1)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#38bdf8',
                },
                {
                    label: 'Rata-rata Skor',
                    data: [78, 80, 81, 82.5, 83.1, 83.7],
                    borderColor: '#f59e0b',
                    backgroundColor: 'transparent',
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#f59e0b',
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { labels: { color: '#94a3b8', font: { size: 11 } } }
            },
            scales: {
                x: { ticks: { color: '#94a3b8', font: { size: 11 } }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y: { ticks: { color: '#94a3b8', font: { size: 11 } }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y1: {
                    position: 'right',
                    min: 60, max: 100,
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });

    // Distribusi Institusi
    new Chart(document.getElementById('institusiChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['USU', 'UNIMED', 'POLMED', 'ITM', 'UMSU', 'Lainnya'],
            datasets: [{
                data: [68, 45, 42, 28, 35, 30],
                backgroundColor: ['#0055FF', '#0093DD', '#38bdf8', '#10b981', '#f59e0b', '#a78bfa'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#94a3b8', font: { size: 11 }, padding: 14 }
                }
            },
            cutout: '58%'
        }
    });
</script>
@endpush