<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'peserta_id', 'pembimbing_id', 'jenis', 'periode_label', 'periode_key',
    'total_skor', 'grade', 'komentar', 'tanggal', 'status', 'di_override_admin',
])]
class Penilaian extends Model
{
    protected $table = 'penilaian';

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peserta_id');
    }

    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(PenilaianDetail::class);
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('tanggal')->orderByDesc('id');
    }

    /**
     * Hitung grade dari skor 0–100.
     */
    public static function gradeDariSkor(float $skor): string
    {
        return match (true) {
            $skor >= 90 => 'Sangat Baik',
            $skor >= 80 => 'Baik',
            $skor >= 75 => 'Cukup Baik',
            $skor >= 60 => 'Kurang',
            default => 'Perlu Perbaikan',
        };
    }

    /**
     * Hitung skor berbobot (0–100) dari nilai per-kriteria (skala 0–5)
     * dan bobot tiap kriteria.
     */
    public static function hitungSkorBerbobot(array $nilaiPerKriteria): float
    {
        $totalBobot = 0;
        $totalNilai = 0.0;

        foreach ($nilaiPerKriteria as $kriteriaId => $nilai) {
            $kriteria = KriteriaPenilaian::find($kriteriaId);
            if (! $kriteria) {
                continue;
            }
            $totalBobot += $kriteria->bobot;
            $totalNilai += ((float) $nilai / 5) * $kriteria->bobot;
        }

        if ($totalBobot === 0) {
            return 0.0;
        }

        return round($totalNilai / $totalBobot * 100, 2);
    }

    /** Rata-rata nilai per-kriteria dalam skala 0–5 (untuk tampilan "4.3"). */
    public function getNilaiRataRataAttribute(): string
    {
        $detail = $this->detail;
        if ($detail->isEmpty()) {
            return number_format($this->total_skor / 20, 1);
        }

        return number_format($detail->avg('nilai'), 1);
    }

    public function getTanggalFormatAttribute(): string
    {
        return $this->tanggal?->translatedFormat('j M Y') ?? '';
    }

    protected function casts(): array
    {
        return [
            'total_skor' => 'float',
            'tanggal' => 'date',
            'di_override_admin' => 'boolean',
        ];
    }
}
