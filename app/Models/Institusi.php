<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kode', 'nama', 'singkat', 'jenis', 'kota', 'status'])]
class Institusi extends Model
{
    protected $table = 'institusi';

    public function dataMagang(): HasMany
    {
        return $this->hasMany(DataMagang::class, 'institusi_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getPesertaAktifCountAttribute(): int
    {
        return $this->dataMagang()
            ->whereHas('user', fn ($q) => $q->where('status', 'aktif'))
            ->count();
    }
}
