<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Perkembangan | Magang Komdigi 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<body class="bg-gradient-to-br from-blue-50 via-indigo-50/40 to-slate-50 font-sans text-gray-800 antialiased min-h-screen">
    @include('layouts.header')

    <div class="flex min-h-[calc(120vh-80px)]">
        @include('layouts.sidebar')
    <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Grafik Perkembangan</h1>
            <p class="text-sm text-gray-500 mt-1">Tren skor kinerja selama periode magang</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-medium">Skor Kinerja Mingguan</h2>
                <span class="text-xs text-gray-500">5 minggu terakhir</span>
            </div>
            <div class="h-72">
                <canvas id="progressChart"></canvas>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="font-medium mb-3">Ringkasan</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Skor awal</p>
                    <p class="font-semibold text-lg">72</p>
                </div>
                <div>
                    <p class="text-gray-500">Skor saat ini</p>
                    <p class="font-semibold text-lg text-komdigi-blue">85</p>
                </div>
                <div>
                    <p class="text-gray-500">Peningkatan</p>
                    <p class="font-semibold text-lg text-green-600">+13</p>
                </div>
                <div>
                    <p class="text-gray-500">Rata-rata</p>
                    <p class="font-semibold text-lg">79.8</p>
                </div>
            </div>
        </div>
    </main>
    </div>

    <script>
        new Chart(document.getElementById('progressChart'), {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Skor',
                    data: [72, 78, 81, 83, 85],
                    borderColor: '#0055FF',
                    backgroundColor: 'rgba(0, 85, 255, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#0055FF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { min: 60, max: 100, grid: { color: '#f3f4f6' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    </script>
</body>
</html>