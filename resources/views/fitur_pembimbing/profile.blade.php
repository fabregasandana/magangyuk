@extends('layouts.pembimbing')

@section('title', 'Profil')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-blue-100/80 font-medium">Manajemen Bimbingan</p>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Profil Saya</h1>
        </div>
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">12.00.00 WIB</p>
            </div>
        </div>
    </div>

    <!-- Profile Hero -->
    <div class="glass-card rounded-3xl p-6 sm:p-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="relative shrink-0">
                <div class="w-28 h-28 rounded-3xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/30">
                    {{ $mentor['inisial'] }}
                </div>
                <button type="button" class="absolute -bottom-2 -right-2 w-9 h-9 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition" title="Ubah foto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
            </div>
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3 mb-1">
                    <h2 class="text-2xl font-black text-white">{{ $mentor['nama'] }}</h2>
                    <span class="inline-flex self-center md:self-auto items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                    </span>
                </div>
                <p class="text-sm text-komdigi-cerulean font-semibold mb-3">{{ $mentor['role'] }} Magang • {{ $mentor['instansi_singkat'] }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-2">
                    <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                        <span class="text-slate-500">NIP:</span> {{ $mentor['nip'] }}
                    </span>
                    <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                        <span class="text-slate-500">ID:</span> {{ $mentor['id_pembimbing'] }}
                    </span>
                    <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                        <span class="text-slate-500">Unit:</span> {{ $mentor['unit_kerja'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($statistik as $stat)
            <div class="glass-card rounded-2xl p-5 text-center">
                <p class="text-2xl font-black {{ $stat['warna'] }}">{{ $stat['nilai'] }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        <!-- Left: Data Pribadi + Keamanan -->
        <div class="xl:col-span-3 space-y-5">
            <!-- Data Pribadi -->
            <div class="glass-card rounded-3xl p-5 sm:p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Data Pribadi</h3>
                    </div>
                    <button type="button" id="btnEditProfile" data-action="edit-profil" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Edit</button>
                </div>

                <form id="profileForm" method="POST" action="{{ route('pembimbing.profile.update') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="form-label" for="nama">Nama Lengkap</label>
                        <input type="text" class="form-input" id="nama" name="nama" data-profile-field value="{{ old('nama', $mentor['nama']) }}" disabled>
                    </div>
                    <div>
                        <label class="form-label" for="nip">NIP</label>
                        <input type="text" class="form-input" id="nip" name="nip" data-profile-field value="{{ old('nip', $mentor['nip']) }}" disabled>
                    </div>
                    <div>
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-input" id="email" name="email" data-profile-field value="{{ old('email', $mentor['email']) }}" disabled>
                    </div>
                    <div>
                        <label class="form-label" for="telepon">No. Telepon</label>
                        <input type="text" class="form-input" id="telepon" name="telepon" data-profile-field value="{{ old('telepon', $mentor['telepon']) }}" disabled>
                    </div>
                    <div>
                        <label class="form-label" for="jabatan">Jabatan</label>
                        <input type="text" class="form-input" id="jabatan" name="jabatan" data-profile-field value="{{ old('jabatan', $mentor['jabatan']) }}" disabled>
                    </div>
                    <div>
                        <label class="form-label" for="unit_kerja">Unit Kerja</label>
                        <input type="text" class="form-input" id="unit_kerja" name="unit_kerja" data-profile-field value="{{ old('unit_kerja', $mentor['unit_kerja']) }}" disabled>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label" for="instansi">Instansi</label>
                        <input type="text" class="form-input" id="instansi" name="instansi" data-profile-field value="{{ old('instansi', $mentor['instansi']) }}" disabled>
                    </div>
                    <div class="sm:col-span-2 hidden" id="editActions">
                        <div class="flex justify-end gap-3 mt-2">
                            <button type="button" data-action="cancel-profil" class="px-4 py-2 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30 transition">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ubah Password -->
            <div class="glass-card rounded-3xl p-5 sm:p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-white">Keamanan Akun</h3>
                </div>
                <form method="POST" action="{{ route('pembimbing.password.update') }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="form-label" for="oldPass">Password Saat Ini</label>
                            <input type="password" class="form-input" id="oldPass" name="password_lama" placeholder="Masukkan password saat ini">
                        </div>
                        <div>
                            <label class="form-label" for="newPass">Password Baru</label>
                            <input type="password" class="form-input" id="newPass" name="password_baru" placeholder="Minimal 8 karakter">
                        </div>
                        <div>
                            <label class="form-label" for="confirmPass">Konfirmasi Password Baru</label>
                            <input type="password" class="form-input" id="confirmPass" name="password_baru_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Info Tambahan -->
        <div class="xl:col-span-2 space-y-5">
            <!-- Info Akun -->
            <div class="glass-card rounded-3xl p-5 sm:p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-white">Informasi Akun</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-xs text-slate-400">Role</span>
                        <span class="text-sm font-semibold text-white">{{ $mentor['role'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-xs text-slate-400">ID Pembimbing</span>
                        <span class="text-sm font-semibold text-white">{{ $mentor['id_pembimbing'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-xs text-slate-400">Bergabung</span>
                        <span class="text-sm font-semibold text-white">{{ $mentor['bergabung'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-xs text-slate-400">Periode Aktif</span>
                        <span class="text-sm font-semibold text-white">{{ $mentor['periode_aktif'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-xs text-slate-400">Status Akun</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> {{ $mentor['status_akun'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terakhir -->
            <div class="glass-card rounded-3xl p-5 sm:p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-white">Aktivitas Terakhir</h3>
                </div>
                <div class="space-y-3">
                    @forelse ($aktivitas as $item)
                        <div class="flex gap-3">
                            <div class="w-2 h-2 rounded-full {{ $item['dot'] }} mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-sm text-white font-medium">{{ $item['aksi'] }}</p>
                                <p class="text-[11px] text-slate-400">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-4">Belum ada aktivitas tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
