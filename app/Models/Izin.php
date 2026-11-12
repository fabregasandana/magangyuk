<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'jenis', 'tanggal_mulai', 'tanggal_selesai', 'alasan',
    'bukti_path', 'status', 'reviewed_by', 'catatan_review', 'reviewed_at',
])]
class Izin extends Model
{
    protected $table = 'izin';

    public const JENIS = ['izin', 'sakit', 'cuti', 'lainnya'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function getJenisLabelAttribute(): string
    {
        return ucfirst((string) $this->jenis);
    }

    public function getRentangAttribute(): string
    {
        if (! $this->tanggal_mulai) {
            return '';
        }

        $mulai = $this->tanggal_mulai->translatedFormat('j M Y');
        if (! $this->tanggal_selesai || $this->tanggal_selesai->equalTo($this->tanggal_mulai)) {
            return $mulai;
        }

        return $mulai . ' – ' . $this->tanggal_selesai->translatedFormat('j M Y');
    }

    public function getJumlahHariAttribute(): int
    {
        if (! $this->tanggal_mulai || ! $this->tanggal_selesai) {
            return 1;
        }

        return (int) $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }
}
