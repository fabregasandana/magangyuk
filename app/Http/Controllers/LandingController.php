<?php

namespace App\Http\Controllers;

use App\Models\CmsKonten;

/**
 * Landing page publik.
 *
 * Konten diambil dari tabel cms_konten (jenis "kegiatan" dan "dokumentasi").
 * Bila belum ada data sama sekali, dipakai fallback bawaan agar halaman
 * tetap tampil layak selama masa pengembangan.
 */
class LandingController extends Controller
{
    public function index()
    {
        $kegiatans = $this->kegiatans();
        $dokumentasis = $this->dokumentasis();

        return view('index', compact('kegiatans', 'dokumentasis'));
    }

    private function kegiatans(): array
    {
        $baris = CmsKonten::jenis('kegiatan')->aktif()->terurut()->take(6)->get();

        if ($baris->isEmpty()) {
            return $this->kegiatanFallback();
        }

        return $baris->map(function (CmsKonten $k) {
            $payload = $k->payloadData;
            $tanggal = $k->published_at;

            return [
                'img' => $k->gambar_path ?: ($payload['img'] ?? $this->gambarPlaceholder()),
                'badge' => $tanggal?->translatedFormat('j M') ?: strtoupper((string) ($payload['badge'] ?? '—')),
                'kategori' => $k->kategori ?: ($payload['kategori'] ?? 'Umum'),
                'kategoriClass' => $this->kategoriClass($k->kategori),
                'judul' => $k->judul,
                'inisial' => $payload['inisial'] ?? 'MG',
                'avatarClass' => $payload['avatarClass'] ?? 'from-blue-400 to-indigo-500',
                'penulis' => $payload['penulis']
                    ?? trim(($k->penulis?->nama_lengkap ?? 'Admin') . ' · ' . ($tanggal?->translatedFormat('j F Y') ?? '')),
            ];
        })->all();
    }

    private function dokumentasis(): array
    {
        $baris = CmsKonten::jenis('dokumentasi')->aktif()->terurut()->take(8)->get();

        if ($baris->isEmpty()) {
            return $this->dokumentasiFallback();
        }

        $ringClasses = [
            'hover:ring-komdigi-blue/30',
            'hover:ring-purple-400/30',
            'hover:ring-pink-400/30',
            'hover:ring-komdigi-gold/40',
        ];

        return $baris->values()->map(fn (CmsKonten $d, int $i) => [
            'img' => $d->gambar_path ?: ($d->payloadData['img'] ?? 'images/alip5.jpeg'),
            'judul' => $d->judul,
            'ringClass' => $ringClasses[$i % count($ringClasses)],
        ])->all();
    }

    private function kategoriClass(?string $kategori): string
    {
        return match (strtolower((string) $kategori)) {
            'pribadi' => 'bg-komdigi-blue/90',
            'semua user', 'umum' => 'bg-gray-700/90',
            'penting' => 'bg-komdigi-red/90',
            default => 'bg-emerald-600/90',
        };
    }

    private function gambarPlaceholder(): string
    {
        return 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop';
    }

    private function kegiatanFallback(): array
    {
        return [
            [
                'img' => 'https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?w=600&h=400&fit=crop',
                'badge' => '—', 'kategori' => 'Umum', 'kategoriClass' => 'bg-gray-700/90',
                'judul' => 'Belum ada kegiatan dipublikasikan',
                'inisial' => 'MG', 'avatarClass' => 'from-blue-400 to-indigo-500',
                'penulis' => 'Admin MagangYuk',
            ],
        ];
    }

    private function dokumentasiFallback(): array
    {
        return [
            ['img' => 'images/alip5.jpeg', 'judul' => 'Dokumentasi 1', 'ringClass' => 'hover:ring-komdigi-blue/30'],
            ['img' => 'images/alip2.jpg', 'judul' => 'Dokumentasi 2', 'ringClass' => 'hover:ring-purple-400/30'],
            ['img' => 'images/alip3.jpg', 'judul' => 'Dokumentasi 3', 'ringClass' => 'hover:ring-pink-400/30'],
            ['img' => 'images/alip4.jpeg', 'judul' => 'Dokumentasi 4', 'ringClass' => 'hover:ring-komdigi-gold/40'],
        ];
    }
}
