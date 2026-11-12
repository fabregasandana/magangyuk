<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipe', 20)->default('mingguan')->index();
            $table->unsignedTinyInteger('minggu_ke')->nullable();
            $table->string('judul')->nullable();
            $table->longText('isi')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            // Tidak pakai unique: minggu_ke bernilai NULL untuk laporan akhir
            // dan Postgres menganggap NULL berbeda satu sama lain.
            // Keunikan dijaga di lapisan aplikasi via updateOrCreate().
            $table->index(['user_id', 'tipe', 'minggu_ke'], 'laporan_user_tipe_minggu_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
