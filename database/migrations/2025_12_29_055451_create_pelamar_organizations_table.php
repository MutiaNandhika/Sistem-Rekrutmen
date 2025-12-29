<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelamar_organizations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_organisasi');
            $table->string('posisi');

            $table->unsignedTinyInteger('mulai_bulan')->nullable();
            $table->unsignedSmallInteger('mulai_tahun')->nullable();

            $table->boolean('masih_aktif')->default(false);
            $table->unsignedTinyInteger('selesai_bulan')->nullable();
            $table->unsignedSmallInteger('selesai_tahun')->nullable();

            $table->text('informasi_tambahan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelamar_organizations');
    }
};
