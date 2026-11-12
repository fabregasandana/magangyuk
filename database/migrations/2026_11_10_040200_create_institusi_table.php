<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institusi', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama');
            $table->string('singkat', 30)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->string('kota', 80)->nullable();
            $table->string('status', 20)->default('aktif')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institusi');
    }
};
