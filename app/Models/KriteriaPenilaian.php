<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kode', 'nama', 'bobot', 'deskripsi', 'urutan', 'aktif'])]
class KriteriaPenilaian extends Model
{
    protected $table = 'kriteria_penilaian';

    public function detail(): HasMany
    {
        return $this->hasMany(PenilaianDetail::class, 'kriteria_penilaian_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeTerurut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }

    /** Persentase bobot terhadap total bobot semua kriteria aktif. */
    public function getPersenBobotAttribute(): float
    {
        $total = (int) static::aktif()->sum('bobot');

        return $total > 0 ? round($this->bobot / $total * 100, 1) : 0.0;
    }

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'bobot' => 'integer',
            'urutan' => 'integer',
        ];
    }
}
