<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('minggu_ke');
            $table->string('rentang', 60)->nullable();
            $table->text('uraian')->nullable();
            $table->json('kegiatan')->nullable();
            $table->text('hasil')->nullable();
            $table->text('kendala')->nullable();
            $table->json('rencana')->nullable();
            $table->string('status', 20)->default('menunggu')->index();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan_review')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'minggu_ke']);
            $table->index(['status', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
