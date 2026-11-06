<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat | Magang Komdigi 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'komdigi-blue': '#0055FF',
                        'komdigi-dark': '#00336C',
                        'komdigi-cerulean': '#0093DD',
                        'komdigi-gold': '#FFB700',
                        'komdigi-red': '#C41E3A',
                        'komdigi-light': '#E8F1FF',
                        'komdigi-soft': '#E0EDFF',
                        'komdigi-mid': '#C5DBFF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { overflow-x: hidden; }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -12px rgba(0, 51, 108, 0.12);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen">

    @include('layouts.header')

    <div class="flex min-h-[calc(120vh-80px)]">
        @include('layouts.sidebar')
    <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Sertifikat Magang</h1>
            <p class="text-sm text-gray-500 mt-1">Kelengkapan syarat penerbitan sertifikat</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Progress kelengkapan</p>
                    <p class="text-3xl font-semibold text-komdigi-gold">68%</p>
                </div>
                <div class="w-32">
                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-komdigi-gold rounded-full" style="width: 68%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-center">
                <p class="text-sm text-gray-600 mb-2">Sertifikat masih terkunci</p>
                <button disabled class="px-4 py-2 bg-gray-200 text-gray-500 text-sm rounded cursor-not-allowed">
                    Unduh Sertifikat
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="font-medium mb-3">Syarat Penerbitan</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xs mt-0.5 shrink-0">✓</span>
                    <div>
                        <p class="font-medium text-green-700">Absensi minimal 80%</p>
                        <p class="text-gray-500">Saat ini 92%</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xs mt-0.5 shrink-0">✓</span>
                    <div>
                        <p class="font-medium text-green-700">Laporan mingguan</p>
                        <p class="text-gray-500">5 dari 8 laporan sudah disetujui</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xs mt-0.5 shrink-0">○</span>
                    <div>
                        <p class="font-medium text-gray-500">Laporan akhir disetujui</p>
                        <p class="text-gray-400">Belum dikumpulkan</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xs mt-0.5 shrink-0">○</span>
                    <div>
                        <p class="font-medium text-gray-500">Penilaian pembimbing final</p>
                        <p class="text-gray-400">Menunggu akhir periode</p>
                    </div>
                </li>
            </ul>
        </div>
    </main>
</body>
</html>