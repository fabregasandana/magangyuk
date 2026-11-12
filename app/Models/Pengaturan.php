<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value', 'grup', 'label'])]
class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    /**
     * Ambil nilai pengaturan. Nilai scalar dibungkus jadi ['value' => x]
     * saat disimpan agar kolom json tetap konsisten.
     */
    public static function ambil(string $key, mixed $default = null): mixed
    {
        $baris = static::where('key', $key)->first();
        if (! $baris || $baris->value === null) {
            return $default;
        }

        $nilai = $baris->value;

        return is_array($nilai) && array_key_exists('value', $nilai)
            ? $nilai['value']
            : $nilai;
    }

    public static function simpan(string $key, mixed $value, string $grup = 'umum', ?string $label = null): void
    {
        $payload = is_array($value) && ! array_key_exists('value', $value)
            ? $value
            : ['value' => $value];

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $payload, 'grup' => $grup, 'label' => $label],
        );
    }

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }
}
