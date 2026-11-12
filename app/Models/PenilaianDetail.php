<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['penilaian_id', 'kriteria_penilaian_id', 'nilai'])]
class PenilaianDetail extends Model
{
    protected $table = 'penilaian_detail';

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_penilaian_id');
    }

    protected function casts(): array
    {
        return [
            'nilai' => 'float',
        ];
    }
}
