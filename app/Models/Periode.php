<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kode', 'nama', 'tanggal_mulai', 'tanggal_selesai', 'status', 'maks_peserta'])]
class Periode extends Model
{
    protected $table = 'periode';

    public function dataMagang(): HasMany
    {
        return $this->hasMany(DataMagang::class, 'periode_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getRentangAttribute(): string
    {
        if (! $this->tanggal_mulai || ! $this->tanggal_selesai) {
            return $this->nama;
        }

        return $this->tanggal_mulai->translatedFormat('j M Y')
            . ' – ' . $this->tanggal_selesai->translatedFormat('j M Y');
    }

    /** Persentase berjalannya periode (0–100) untuk progress bar dashboard. */
    public function getProgressAttribute(): int
    {
        if (! $this->tanggal_mulai || ! $this->tanggal_selesai) {
            return 0;
        }

        $total = $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
        if ($total <= 0) {
            return 100;
        }

        $berjalan = $this->tanggal_mulai->diffInDays(now());

        return (int) max(0, min(100, round($berjalan / $total * 100)));
    }

    public function getSisaHariAttribute(): int
    {
        return (int) max(0, now()->diffInDays($this->tanggal_selesai, false));
    }

    /* ================== PEMBAGIAN MINGGU MAGANG ================== */

    public function getTotalMingguAttribute(): int
    {
        if (! $this->tanggal_mulai || ! $this->tanggal_selesai) {
            return 1;
        }

        return (int) max(1, ceil(($this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1) / 7));
    }

    public function mulaiMinggu(int $minggu): ?\Illuminate\Support\Carbon
    {
        return $this->tanggal_mulai?->copy()->addDays(($minggu - 1) * 7);
    }

    public function selesaiMinggu(int $minggu): ?\Illuminate\Support\Carbon
    {
        return $this->mulaiMinggu($minggu)?->copy()->addDays(6);
    }

    public function rentangMinggu(int $minggu): string
    {
        $mulai = $this->mulaiMinggu($minggu);
        $selesai = $this->selesaiMinggu($minggu);

        if (! $mulai || ! $selesai) {
            return 'Minggu ke-' . $minggu;
        }

        return $mulai->translatedFormat('j') . ' – ' . $selesai->translatedFormat('j M Y');
    }

    /** Nomor minggu yang memuat tanggal tertentu (default: hari ini). */
    public function mingguAktif(?\Illuminate\Support\Carbon $tanggal = null): int
    {
        $tanggal = ($tanggal ?? now())->copy()->startOfDay();
        $mulai = $this->tanggal_mulai?->copy()->startOfDay();

        if (! $mulai) {
            return 1;
        }

        if ($tanggal->lessThan($mulai)) {
            return 1;
        }

        $minggu = (int) floor($mulai->diffInDays($tanggal) / 7) + 1;

        return (int) max(1, min($this->total_minggu, $minggu));
    }

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }
}
