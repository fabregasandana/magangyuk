<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'role', 'aksi', 'deskripsi', 'ip'])]
class ActivityLog extends Model
{
    protected $table = 'activity_log';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat satu aksi. Aman dipanggil meski tidak ada user login.
     */
    public static function catat(string $aksi, ?string $deskripsi = null, ?User $user = null): void
    {
        $user ??= auth()->user();

        static::create([
            'user_id' => $user?->id,
            'role' => $user?->role,
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'ip' => request()->ip(),
        ]);
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('created_at')->orderByDesc('id');
    }

    public function getWaktuAttribute(): string
    {
        return $this->created_at?->translatedFormat('d/m/Y H.i') ?? '';
    }

    public function getUserNamaAttribute(): string
    {
        return $this->user?->nama_lengkap ?? 'Sistem';
    }
}
