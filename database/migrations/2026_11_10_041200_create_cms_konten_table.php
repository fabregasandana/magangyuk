<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_konten', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 40)->index();
            $table->string('judul');
            $table->string('slug')->nullable()->unique();
            $table->longText('isi')->nullable();
            $table->json('payload')->nullable();
            $table->string('gambar_path')->nullable();
            $table->string('file_path')->nullable();
            $table->string('kategori', 60)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('urutan')->default(0);
            $table->string('status', 20)->default('aktif')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['jenis', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_konten');
    }
};
