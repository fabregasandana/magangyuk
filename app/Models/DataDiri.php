<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('data_diri')]
#[Fillable([
    'user_id', 'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
    'alamat', 'jenis_kelamin', 'email', 'no_hp',
    'nip', 'jabatan', 'unit_kerja', 'instansi',
])]
class DataDiri extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTanggalLahirFormatAttribute(): ?string
    {
        if (empty($this->tanggal_lahir)) {
            return null;
        }

        $tanggal = \Illuminate\Support\Carbon::parse($this->tanggal_lahir);
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return $tanggal->day . ' ' . $bulan[(int) $tanggal->format('n')] . ' ' . $tanggal->year;
    }

    public function getTtlAttribute(): string
    {
        return trim($this->tempat_lahir . ', ' . ($this->tanggal_lahir_format ?? ''));
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date:Y-m-d',
        ];
    }
}
