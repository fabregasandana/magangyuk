<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'minggu_ke', 'rentang', 'uraian', 'kegiatan', 'hasil',
    'kendala', 'rencana', 'status', 'reviewed_by', 'catatan_review', 'submitted_at',
])]
class Logbook extends Model
{
    protected $table = 'logbook';

    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DISETUJUI = 'disetujui';
    public const STATUS_DITOLAK = 'ditolak';

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
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function getKegiatanListAttribute(): array
    {
        return is_array($this->kegiatan) ? $this->kegiatan : [];
    }

    public function getRencanaListAttribute(): array
    {
        return is_array($this->rencana) ? $this->rencana : [];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DISETUJUI => 'Disetujui',
            self::STATUS_DITOLAK => 'Ditolak',
            default => 'Menunggu Review',
        };
    }

    protected function casts(): array
    {
        return [
            'kegiatan' => 'array',
            'rencana' => 'array',
            'submitted_at' => 'datetime',
            'minggu_ke' => 'integer',
        ];
    }
}
