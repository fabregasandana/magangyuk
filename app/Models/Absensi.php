<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable([
    'user_id', 'tanggal', 'jam_masuk', 'jam_pulang', 'status', 'keterangan',
    'foto_masuk_path', 'foto_pulang_path', 'latitude', 'longitude', 'lokasi',
])]
class Absensi extends Model
{
    protected $table = 'absensi';

    /** Batas jam masuk yang masih dihitung "hadir" (toleransi 15 menit). */
    public const JAM_MASUK = '08:00';
    public const JAM_PULANG = '16:00';
    public const TOLERANSI_MENIT = 15;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tentukan status dari jam masuk: hadir / terlambat.
     */
    public static function statusDariJamMasuk(?string $jam): string
    {
        if (! $jam) {
            return 'menunggu';
        }

        $batas = Carbon::createFromFormat('H:i:s', self::JAM_MASUK . ':00')
            ->addMinutes(self::TOLERANSI_MENIT);
        $masuk = Carbon::createFromFormat('H:i:s', substr($jam, 0, 8));

        return $masuk->greaterThan($batas) ? 'terlambat' : 'hadir';
    }

    public function getDurasiAttribute(): ?string
    {
        if (! $this->jam_masuk || ! $this->jam_pulang) {
            return null;
        }

        $menit = Carbon::createFromFormat('H:i:s', substr($this->jam_masuk, 0, 8))
            ->diffInMinutes(Carbon::createFromFormat('H:i:s', substr($this->jam_pulang, 0, 8)));

        if ($menit === null || $menit < 0) {
            return null;
        }

        return floor($menit / 60) . 'j ' . ($menit % 60) . 'm';
    }

    public function getDetailAttribute(): string
    {
        if (! $this->jam_masuk && ! $this->jam_pulang) {
            return $this->keterangan ?: 'Belum absen';
        }

        $bagian = [];
        if ($this->jam_masuk) {
            $bagian[] = 'Masuk ' . substr($this->jam_masuk, 0, 5);
        }
        if ($this->jam_pulang) {
            $bagian[] = 'Pulang ' . substr($this->jam_pulang, 0, 5);
        }
        if ($this->durasi) {
            $bagian[] = 'Durasi ' . $this->durasi;
        }

        return implode(' · ', $bagian);
    }

    public function getTanggalPanjangAttribute(): string
    {
        return $this->tanggal?->translatedFormat('l, j F Y') ?? '';
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }
}
