<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('data_magang')]
#[Fillable([
    'user_id', 'id_kode', 'nis_nim', 'institusi', 'institusi_id', 'prodi',
    'penempatan', 'bidang', 'periode', 'periode_id', 'status', 'pembimbing_id',
])]
class DataMagang extends Model
{
    public const STATUSES = ['aktif', 'nonaktif', 'selesai', 'menunggu'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function institusiRel(): BelongsTo
    {
        return $this->belongsTo(Institusi::class, 'institusi_id');
    }

    public function periodeRel(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    /** Label institusi: pakai relasi bila ada, fallback ke kolom string lama. */
    public function getInstitusiLabelAttribute(): string
    {
        return $this->institusiRel?->nama ?: (string) $this->institusi;
    }

    public function getInstitusiSingkatAttribute(): string
    {
        return $this->institusiRel?->singkat ?: (string) $this->institusi;
    }

    public function getPeriodeLabelAttribute(): string
    {
        return $this->periodeRel?->nama ?: (string) $this->periode;
    }

    public function getPembimbingNamaAttribute(): string
    {
        return $this->pembimbing?->nama_lengkap ?? 'Belum ditentukan';
    }
}
