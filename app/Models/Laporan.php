<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'tipe', 'minggu_ke', 'judul', 'isi', 'file_path', 'status',
    'submitted_at', 'reviewed_by', 'catatan', 'reviewed_at',
])]
class Laporan extends Model
{
    protected $table = 'laporan';

    public const TIPE_MINGGUAN = 'mingguan';
    public const TIPE_AKHIR = 'akhir';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopeMingguan($query)
    {
        return $query->where('tipe', self::TIPE_MINGGUAN);
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function getJudulLabelAttribute(): string
    {
        return $this->judul ?: ($this->tipe === self::TIPE_AKHIR
            ? 'Laporan Akhir'
            : 'Minggu ' . $this->minggu_ke);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'disetujui' => 'Disetujui',
            'ditolak' => 'Perlu Revisi',
            'menunggu' => 'Menunggu Review',
            default => 'Draft',
        };
    }

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'minggu_ke' => 'integer',
        ];
    }
}
