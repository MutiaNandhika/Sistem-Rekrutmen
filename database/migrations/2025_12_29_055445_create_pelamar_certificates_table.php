<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelamar_certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_sertifikat');
            $table->string('organisasi_penerbit');

            $table->unsignedTinyInteger('bulan_terbit')->nullable(); // 1-12
            $table->unsignedSmallInteger('tahun_terbit')->nullable();

            $table->boolean('tanpa_expired')->default(false);
            $table->unsignedTinyInteger('bulan_expired')->nullable();
            $table->unsignedSmallInteger('tahun_expired')->nullable();

            $table->text('informasi_tambahan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelamar_certificates');
    }
};
