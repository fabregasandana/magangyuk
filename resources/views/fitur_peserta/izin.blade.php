<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Ketidakhadiran | Magang Komdigi 2026</title>
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
            <h1 class="text-xl font-semibold text-gray-900">Ajukan Ketidakhadiran</h1>
            <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah untuk mengajukan izin, sakit, atau cuti</p>
        </div>

        <!-- Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <form class="space-y-5">

                <!-- Jenis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Ketidakhadiran</label>
                    <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-komdigi-blue focus:border-komdigi-blue">
                        <option value="">Pilih jenis</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="cuti">Cuti</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                        <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-komdigi-blue focus:border-komdigi-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                        <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-komdigi-blue focus:border-komdigi-blue">
                    </div>
                </div>

                <!-- Alasan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alasan / Keterangan</label>
                    <textarea rows="4" placeholder="Jelaskan alasan ketidakhadiran..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-komdigi-blue focus:border-komdigi-blue resize-none"></textarea>
                </div>

                <!-- Upload Bukti -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Bukti Pendukung <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <div class="border border-dashed border-gray-300 rounded-md px-4 py-6 text-center">
                        <p class="text-sm text-gray-500 mb-2">Surat dokter, surat izin, atau dokumen lain</p>
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" class="text-sm text-gray-600">
                        <p class="text-xs text-gray-400 mt-2">Format: PDF, JPG, PNG · Maks. 2 MB</p>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit" class="flex-1 py-2.5 bg-komdigi-blue text-white text-sm font-medium rounded hover:bg-komdigi-dark transition">
                        Kirim Pengajuan
                    </button>
                    <a href="dashboard.html" class="flex-1 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded text-center hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

        <!-- Riwayat Pengajuan -->
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h2 class="font-medium text-gray-900 mb-4">Riwayat Pengajuan</h2>

            <div class="space-y-3">
                <!-- Item 1 -->
                <div class="border border-gray-200 rounded-md p-3">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium">Sakit</span>
                            <span class="text-xs px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 rounded">Disetujui</span>
                        </div>
                        <span class="text-xs text-gray-500">15 – 16 Okt 2026</span>
                    </div>
                    <p class="text-sm text-gray-600">Demam dan flu</p>
                    <p class="text-xs text-gray-400 mt-1">Diajukan 14 Okt 2026</p>
                </div>

                <!-- Item 2 -->
                <div class="border border-gray-200 rounded-md p-3">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium">Izin</span>
                            <span class="text-xs px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded">Menunggu</span>
                        </div>
                        <span class="text-xs text-gray-500">3 Nov 2026</span>
                    </div>
                    <p class="text-sm text-gray-600">Keperluan keluarga</p>
                    <p class="text-xs text-gray-400 mt-1">Diajukan 2 Nov 2026</p>
                </div>
            </div>
        </div>

    </main>
</body>
</html>