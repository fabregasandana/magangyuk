<style>
        .sidebar-link {
            transition: all 0.2s ease;
            color: rgba(191, 219, 254, 0.9);
            font-weight: 500;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }
        .sidebar-link.active {
            background: rgba(255,255,255,0.18);
            box-shadow: inset 3px 0 0 #FFB700;
            color: #fff;
            font-weight: 600;
        }
</style>
<!-- SIDEBAR -->
        <aside class="hidden lg:flex flex-col w-64 bg-gradient-to-b from-komdigi-dark via-[#002a5c] to-[#001a3d] text-white shrink-0">
            <div class="p-5">
                <p class="text-[11px] font-bold tracking-widest text-blue-300/80 uppercase mb-4">Menu Utama</p>
                
                <nav class="space-y-1" id="sidebar-nav">
                    <a href="/dashboard" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda
                    </a>
                    <a href="/absen" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Absen
                    </a>
                    <a href="/riwayat" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat
                    </a>
                    <a href="/grafik" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Grafik Perkembangan
                    </a>
                    <a href="/penilaian" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Penilaian & Feedback
                    </a>
                    <a href="/laporan" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Laporan Akhir
                    </a>
                    <a href="/sertifikat" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Sertifikat
                    </a>
                    <a href="#" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Ajukan Ketidakhadiran
                    </a>
                    <a href="#" class="sidebar-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-blue-100/90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div class="mt-auto p-5 border-t border-white/10">
                <div class="bg-white/10 rounded-xl p-3.5">
                    <p class="text-[11px] font-semibold text-blue-200 mb-1">Periode Magang</p>
                    <p class="text-sm font-bold text-white">Okt – Des 2026</p>
                    <div class="mt-2 h-1.5 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-komdigi-gold to-amber-400 rounded-full" style="width: 42%"></div>
                    </div>
                    <p class="text-[10px] text-blue-200/80 mt-1">42% selesai</p>
                </div>
            </div>
        </aside>

    <script>
        // Sidebar active state on click
        document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(link => {
            link.addEventListener('click', function (e) {
                document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(l => {
                    l.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Set active berdasarkan URL saat ini (berguna di Laravel/routing)
        (function setActiveFromUrl() {
            const path = window.location.pathname.replace(/\/$/, '') || '/';
            document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(link => {
                const href = link.getAttribute('href')?.replace(/\/$/, '') || '';
                if (href && (path === href || path.startsWith(href + '/'))) {
                    document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        })();
    </script>