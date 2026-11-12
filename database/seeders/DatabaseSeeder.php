<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder utama MagangYuk.
 *
 * Urutan penting: data master -> akun -> aktivitas -> konten CMS.
 * Seluruh seeder bersifat idempoten (updateOrCreate/firstOrCreate) sehingga
 * aman dijalankan berulang tanpa menduplikasi data.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            MasterSeeder::class,
            AkunSeeder::class,
            AktivitasSeeder::class,
            CmsSeeder::class,
        ]);
    }
}
