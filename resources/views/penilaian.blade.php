<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian | Magang Komdigi 2026</title>
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
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 space-y-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Penilaian Pembimbing</h1>
            <p class="text-sm text-gray-500 mt-1">Hasil evaluasi dari pembimbing lapangan</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Nilai keseluruhan</p>
                    <p class="text-3xl font-semibold text-komdigi-blue">4.3 <span class="text-base font-normal text-gray-500">/ 5.0</span></p>
                </div>
                <div class="text-right text-sm">
                    <p class="text-gray-500">Pembimbing</p>
                    <p class="font-medium">Budi Santoso, S.Kom</p>
                    <p class="text-xs text-gray-400 mt-0.5">Diperbarui 28 Okt 2026</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">Disiplin & Kehadiran</span>
                        <span class="font-medium">4.5</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-full bg-komdigi-blue rounded-full" style="width: 90%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">Kerjasama Tim</span>
                        <span class="font-medium">4.2</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-full bg-komdigi-blue rounded-full" style="width: 84%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">Kompetensi Teknis</span>
                        <span class="font-medium">4.0</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-full bg-komdigi-blue rounded-full" style="width: 80%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">Inisiatif & Kreativitas</span>
                        <span class="font-medium">4.5</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-full bg-komdigi-blue rounded-full" style="width: 90%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="font-medium mb-2">Komentar Pembimbing</h2>
            <p class="text-sm text-gray-700 leading-relaxed">
                "Peserta menunjukkan progres yang baik dan aktif berkontribusi dalam proyek digitalisasi. Disiplin kehadiran sudah cukup baik. Masih bisa ditingkatkan di sisi dokumentasi teknis."
            </p>
            <p class="text-xs text-gray-400 mt-3">— Budi Santoso, S.Kom · 28 Oktober 2026</p>
        </div>
    </main>
    </div>
</body>
</html>