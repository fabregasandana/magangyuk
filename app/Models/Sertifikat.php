<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'nomor', 'file_path', 'progress', 'status', 'issued_at'])]
class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTerbitAttribute(): bool
    {
        return $this->status === 'terbit';
    }

    public function getTerkunciAttribute(): bool
    {
        return ! $this->terbit;
    }

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'progress' => 'integer',
        ];
    }
}
