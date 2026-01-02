<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();

            // HRD pembuat lowongan
            $table->foreignId('hrd_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Informasi utama
            $table->string('nama_lowongan');
            $table->string('bidang_kerja')->nullable();

            // Jenis & sistem kerja
            $table->enum('tipe_kerja', [
                'penuh_waktu',
                'paruh_waktu',
                'freelance'
            ]);

            $table->enum('sistem_kerja', [
                'kantor',
                'remote',
                'hybrid'
            ]);

            // Lokasi & gaji
            $table->string('lokasi')->nullable();
            $table->integer('gaji_min')->nullable();
            $table->integer('gaji_max')->nullable();

            // Persyaratan
            $table->enum('jenis_kelamin', [
                'laki_laki',
                'perempuan',
                'bebas'
            ])->default('bebas');

            $table->integer('usia_min')->nullable();
            $table->integer('usia_max')->nullable();
            $table->boolean('tanpa_batas_usia')->default(false);

            $table->string('pendidikan_minimal')->nullable();
            $table->string('pengalaman_kerja')->nullable();

            // Deskripsi
            $table->longText('deskripsi_pekerjaan')->nullable();

            // Status lowongan
            $table->enum('status', [
                'draft',
                'aktif',
                'nonaktif',
                'arsip'
            ])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
