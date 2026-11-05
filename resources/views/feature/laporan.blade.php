<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Akhir | Magang Komdigi 2026</title>
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
            <h1 class="text-xl font-semibold text-gray-900">Laporan Akhir</h1>
            <p class="text-sm text-gray-500 mt-1">Status pengumpulan laporan akhir magang</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold text-amber-700">Belum dikumpulkan</p>
                </div>
                <span class="text-xs px-2 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded">Draft belum ada</span>
            </div>

            <div class="text-sm space-y-2 mb-5">
                <div class="flex justify-between">
                    <span class="text-gray-500">Batas pengumpulan</span>
                    <span class="font-medium">19 Desember 2026</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Sisa waktu</span>
                    <span class="font-medium">45 hari</span>
                </div>
            </div>

            <a href="#" class="block w-full text-center py-2.5 bg-komdigi-blue text-white text-sm font-medium rounded hover:bg-komdigi-dark transition">
                Mulai Buat Laporan Akhir
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="font-medium mb-3">Checklist</h2>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-2 text-green-700">
                    <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-xs">✓</span>
                    Laporan mingguan (5 dari 8)
                </li>
                <li class="flex items-center gap-2 text-gray-400">
                    <span class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-xs">○</span>
                    Draft laporan akhir
                </li>
                <li class="flex items-center gap-2 text-gray-400">
                    <span class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-xs">○</span>
                    Review pembimbing
                </li>
                <li class="flex items-center gap-2 text-gray-400">
                    <span class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-xs">○</span>
                    Persetujuan final
                </li>
            </ul>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="font-medium mb-3">Laporan Mingguan Terakhir</h2>
            <div class="text-sm">
                <p class="font-medium">Laporan Minggu ke-5</p>
                <p class="text-gray-500 mt-0.5">Dikirim 28 Oktober 2026 · Status: Disetujui</p>
                <a href="#" class="text-komdigi-blue hover:underline text-sm mt-2 inline-block">Lihat laporan</a>
            </div>
        </div>
    </main>
    </div>
</body>
</html>