<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Perbaikan tipe kolom data_diri (temuan review bagian A):
 *  - nik & no_hp: integer -> string (agar NIK 16 digit & nomor HP "0812..." tidak rusak)
 *  - tanggal_lahir: string -> date
 * Tabel saat ini kosong sehingga konversi tipe aman. Pakai statement mentah
 * dengan klausa USING karena PostgreSQL tak meng-cast otomatis ke tipe tsb.
 * Sekaligus menambah kolom profil pembimbing (nip, jabatan, unit_kerja, instansi).
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE data_diri ALTER COLUMN nik TYPE varchar(20) USING nik::varchar");
        DB::statement("ALTER TABLE data_diri ALTER COLUMN no_hp TYPE varchar(20) USING no_hp::varchar");
        DB::statement("ALTER TABLE data_diri ALTER COLUMN tanggal_lahir TYPE date USING NULLIF(tanggal_lahir, '')::date");

        Schema::table('data_diri', function (Blueprint $table) {
            $table->string('nip', 50)->nullable();
            $table->string('jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('instansi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('data_diri', function (Blueprint $table) {
            $table->dropColumn(['nip', 'jabatan', 'unit_kerja', 'instansi']);
        });

        DB::statement("ALTER TABLE data_diri ALTER COLUMN nik TYPE integer USING NULLIF(nik, '')::integer");
        DB::statement("ALTER TABLE data_diri ALTER COLUMN no_hp TYPE integer USING NULLIF(no_hp, '')::integer");
        DB::statement("ALTER TABLE data_diri ALTER COLUMN tanggal_lahir TYPE varchar USING tanggal_lahir::varchar");
    }
};
