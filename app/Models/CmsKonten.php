<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'jenis', 'judul', 'slug', 'isi', 'payload', 'gambar_path', 'file_path',
    'kategori', 'user_id', 'urutan', 'status', 'published_at',
])]
class CmsKonten extends Model
{
    protected $table = 'cms_konten';

    public const JENIS = [
        'kegiatan', 'dokumentasi', 'anggota', 'halaman',
        'pengumuman', 'hero', 'menu', 'dokumen', 'faq',
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTerurut($query)
    {
        return $query->orderBy('urutan')->orderByDesc('published_at')->orderByDesc('id');
    }

    protected static function booted(): void
    {
        static::saving(function (self $konten) {
            if (empty($konten->slug) && ! empty($konten->judul)) {
                $konten->slug = Str::slug($konten->judul);
            }
        });
    }

    public function getPayloadDataAttribute(): array
    {
        return is_array($this->payload) ? $this->payload : [];
    }

    public function getPublishedFormatAttribute(): string
    {
        return $this->published_at?->translatedFormat('j F Y') ?? '';
    }

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'published_at' => 'datetime',
            'urutan' => 'integer',
        ];
    }
}
