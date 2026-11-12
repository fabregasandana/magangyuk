<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 80);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('status', 20)->default('aktif')->index();
            $table->unsignedInteger('maks_peserta')->default(50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
