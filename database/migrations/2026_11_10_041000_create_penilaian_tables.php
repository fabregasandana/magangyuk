<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pembimbing_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('jenis', 20)->default('mingguan')->index();
            $table->string('periode_label', 80)->nullable();
            $table->string('periode_key', 40)->nullable();
            $table->decimal('total_skor', 5, 2)->default(0);
            $table->string('grade', 30)->nullable();
            $table->text('komentar')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('status', 20)->default('final')->index();
            $table->boolean('di_override_admin')->default(false);
            $table->timestamps();

            $table->index(['peserta_id', 'jenis']);
        });

        Schema::create('penilaian_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('penilaian')->cascadeOnDelete();
            $table->foreignId('kriteria_penilaian_id')->constrained('kriteria_penilaian')->cascadeOnDelete();
            $table->decimal('nilai', 5, 2)->default(0);
            $table->timestamps();

            $table->unique(['penilaian_id', 'kriteria_penilaian_id'], 'penilaian_detail_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_detail');
        Schema::dropIfExists('penilaian');
    }
};
