<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan relasi institusi/periode + kode peserta pada data_magang.
     * Kolom string lama (institusi, periode) tetap dipertahankan sebagai label
     * tampilan agar tidak merusak data yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('data_magang', function (Blueprint $table) {
            $table->string('id_kode', 30)->nullable()->unique()->after('user_id');
            $table->foreignId('institusi_id')->nullable()->after('institusi')
                ->constrained('institusi')->nullOnDelete();
            $table->foreignId('periode_id')->nullable()->after('periode')
                ->constrained('periode')->nullOnDelete();
        });

        // Kolom warisan boleh kosong karena sekarang diisi via relasi.
        DB::statement('ALTER TABLE data_magang ALTER COLUMN nis_nim DROP NOT NULL');
        DB::statement('ALTER TABLE data_magang ALTER COLUMN institusi DROP NOT NULL');
        DB::statement('ALTER TABLE data_magang ALTER COLUMN prodi DROP NOT NULL');
        DB::statement('ALTER TABLE data_magang ALTER COLUMN penempatan DROP NOT NULL');
        DB::statement('ALTER TABLE data_magang ALTER COLUMN bidang DROP NOT NULL');
        DB::statement('ALTER TABLE data_magang ALTER COLUMN periode DROP NOT NULL');
        DB::statement('ALTER TABLE data_magang ALTER COLUMN status DROP NOT NULL');
        DB::statement("ALTER TABLE data_magang ALTER COLUMN status SET DEFAULT 'aktif'");
    }

    public function down(): void
    {
        Schema::table('data_magang', function (Blueprint $table) {
            $table->dropConstrainedForeignId('institusi_id');
            $table->dropConstrainedForeignId('periode_id');
            $table->dropColumn('id_kode');
        });
    }
};
