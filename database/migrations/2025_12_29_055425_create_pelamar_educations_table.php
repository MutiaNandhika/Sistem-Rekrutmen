<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelamar_educations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('tingkat'); // SMA/SMK, D3, S1, S2, dll
            $table->string('nama_sekolah');
            $table->string('bidang_studi')->nullable();

            $table->unsignedSmallInteger('mulai_tahun')->nullable();
            $table->unsignedTinyInteger('selesai_bulan')->nullable(); // 1-12
            $table->unsignedSmallInteger('selesai_tahun')->nullable();

            $table->text('informasi_tambahan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelamar_educations');
    }
};
