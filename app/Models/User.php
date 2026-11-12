<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama_lengkap', 'email', 'password', 'role', 'status', 'avatar_path'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_PESERTA = 'peserta';
    public const ROLE_PEMBIMBING = 'pembimbing';
    public const ROLE_ADMIN = 'admin';

    public const STATUSES = ['aktif', 'nonaktif', 'selesai'];

    /**
     * Banyak view memanggil auth()->user()->name, sedangkan kolom DB
     * sebenarnya adalah nama_lengkap. Accessor ini menjembatani keduanya.
     */
    public function getNameAttribute(): string
    {
        return $this->nama_lengkap;
    }

    public function getInisialAttribute(): string
    {
        $kata = preg_split('/\s+/', trim((string) $this->nama_lengkap)) ?: [];
        $inisial = strtoupper(substr($kata[0] ?? '', 0, 1));
        if (isset($kata[1])) {
            $inisial .= strtoupper(substr($kata[1], 0, 1));
        }

        return $inisial !== '' ? $inisial : '??';
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPembimbing(): bool
    {
        return $this->role === self::ROLE_PEMBIMBING;
    }

    public function isPeserta(): bool
    {
        return $this->role === self::ROLE_PESERTA;
    }

    /**
     * Apakah akun boleh masuk ke sistem.
     *
     * `User::STATUSES` punya tiga nilai dengan arti berbeda:
     *  - `aktif`    : sedang menjalani magang / bertugas.
     *  - `selesai`  : magangnya sudah tamat. Akunnya tetap sah — peserta seperti
     *                 ini justru yang berhak membuka /sertifikat dan /riwayat,
     *                 jadi jangan disamakan dengan akun yang dimatikan.
     *  - `nonaktif` : satu-satunya status yang memblokir akses (dinonaktifkan admin).
     */
    public function isAktif(): bool
    {
        return $this->status !== 'nonaktif';
    }

    /* ============================ RELASI ============================ */

    public function dataDiri(): HasOne
    {
        return $this->hasOne(DataDiri::class);
    }

    public function dataMagang(): HasOne
    {
        return $this->hasOne(DataMagang::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function izin(): HasMany
    {
        return $this->hasMany(Izin::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    public function logbook(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'peserta_id');
    }

    public function penilaianDiberikan(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'pembimbing_id');
    }

    /** Peserta yang dibimbing (untuk role pembimbing). */
    public function pesertaBimbingan(): HasMany
    {
        return $this->hasMany(DataMagang::class, 'pembimbing_id');
    }

    public function sertifikat(): HasOne
    {
        return $this->hasOne(Sertifikat::class);
    }

    public function activityLog(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
