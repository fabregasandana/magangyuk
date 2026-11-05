<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Magang Komdigi 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'komdigi-blue': '#0055FF',
                        'komdigi-dark': '#00336C',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen">

    <header class="sticky top-0 z-50 bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-3">
                    <a href="dashboard.html" class="w-8 h-8 bg-komdigi-blue rounded-lg flex items-center justify-center text-white font-bold text-sm">K</a>
                    <div class="hidden sm:block">
                        <div class="font-semibold text-komdigi-dark text-sm">MAGANG KOMDIGI</div>
                        <div class="text-xs text-gray-500">2026</div>
                    </div>
                </div>
                <a href="dashboard.html" class="text-sm text-komdigi-blue hover:underline">← Kembali ke Dashboard</a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 space-y-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-900">Profil Peserta</h1>
            <p class="text-sm text-gray-500 mt-1">Data diri dan informasi magang</p>
        </div>

        <!-- Header Profil -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <div class="flex flex-col sm:flex-row items-start gap-5">
                <div class="w-20 h-20 rounded-lg bg-komdigi-blue text-white text-2xl font-semibold flex items-center justify-center shrink-0">
                    NR
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h2 class="text-lg font-semibold text-gray-900">Nisa Ramadani</h2>
                        <span class="text-xs px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 rounded">Aktif</span>
                    </div>
                    <p class="text-sm text-gray-500">ID Peserta: MKD-2026-0847</p>
                    <p class="text-sm text-gray-500 mt-0.5">Peserta Magang · Dinas Kominfo Sumatera Utara</p>
                </div>
                <button class="text-sm px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                    Ubah Foto
                </button>
            </div>
        </div>

        <!-- Data Pribadi -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-medium text-gray-900">Data Pribadi</h3>
                <button class="text-sm text-komdigi-blue hover:underline">Edit</button>
            </div>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Nama Lengkap</p>
                    <p class="font-medium mt-0.5">Nisa Ramadani</p>
                </div>
                <div>
                    <p class="text-gray-500">NIM / NIS</p>
                    <p class="font-medium mt-0.5">210401023</p>
                </div>
                <div>
                    <p class="text-gray-500">Tempat, Tanggal Lahir</p>
                    <p class="font-medium mt-0.5">Medan, 12 Maret 2003</p>
                </div>
                <div>
                    <p class="text-gray-500">Jenis Kelamin</p>
                    <p class="font-medium mt-0.5">Perempuan</p>
                </div>
                <div>
                    <p class="text-gray-500">Email</p>
                    <p class="font-medium mt-0.5">nisa.ramadani@students.usu.ac.id</p>
                </div>
                <div>
                    <p class="text-gray-500">No. HP / WhatsApp</p>
                    <p class="font-medium mt-0.5">0812-3456-7890</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-gray-500">Alamat</p>
                    <p class="font-medium mt-0.5">Jl. Dr. Mansyur No. 12, Medan Selayang, Kota Medan, Sumatera Utara 20155</p>
                </div>
            </div>
        </div>

        <!-- Data Institusi -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-medium text-gray-900">Data Institusi</h3>
                <button class="text-sm text-komdigi-blue hover:underline">Edit</button>
            </div>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Perguruan Tinggi / Sekolah</p>
                    <p class="font-medium mt-0.5">Universitas Sumatera Utara</p>
                </div>
                <div>
                    <p class="text-gray-500">Fakultas / Jurusan</p>
                    <p class="font-medium mt-0.5">Ilmu Komputer / Sistem Informasi</p>
                </div>
                <div>
                    <p class="text-gray-500">Semester / Tingkat</p>
                    <p class="font-medium mt-0.5">Semester 7</p>
                </div>
                <div>
                    <p class="text-gray-500">Dosen / Guru Pembimbing</p>
                    <p class="font-medium mt-0.5">Dr. Andi Pratama, M.Kom</p>
                </div>
            </div>
        </div>

        <!-- Data Magang -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h3 class="font-medium text-gray-900 mb-4">Data Magang</h3>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Unit Kerja</p>
                    <p class="font-medium mt-0.5">Dinas Komunikasi dan Informatika Provinsi Sumatera Utara</p>
                </div>
                <div>
                    <p class="text-gray-500">Pembimbing Lapangan</p>
                    <p class="font-medium mt-0.5">Budi Santoso, S.Kom</p>
                </div>
                <div>
                    <p class="text-gray-500">Periode Magang</p>
                    <p class="font-medium mt-0.5">1 Oktober 2026 – 19 Desember 2026</p>
                </div>
                <div>
                    <p class="text-gray-500">Status</p>
                    <p class="font-medium mt-0.5 text-green-700">Aktif</p>
                </div>
                <div>
                    <p class="text-gray-500">Progress Periode</p>
                    <div class="mt-1.5">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>42%</span>
                            <span>45 hari tersisa</span>
                        </div>
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-komdigi-blue rounded-full" style="width: 42%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akun -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h3 class="font-medium text-gray-900 mb-4">Akun</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">Email Login</p>
                        <p class="text-gray-500">nisa.ramadani@students.usu.ac.id</p>
                    </div>
                    <button class="text-komdigi-blue hover:underline">Ubah</button>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <div>
                        <p class="font-medium">Password</p>
                        <p class="text-gray-500">••••••••</p>
                    </div>
                    <button class="text-komdigi-blue hover:underline">Ubah Password</button>
                </div>
            </div>
        </div>

    </main>
</body>
</html>