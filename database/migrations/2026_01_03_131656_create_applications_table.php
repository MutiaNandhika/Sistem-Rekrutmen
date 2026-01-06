<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('lowongan_id')
                ->constrained('lowongans')
                ->cascadeOnDelete();

            $table->enum('status', [
                'diproses',
                'screening',
                'interview',
                'offer',
                'diterima',
                'ditolak'
            ])->default('diproses');

            $table->timestamps();

            // 1 pelamar hanya boleh 1 lamaran aktif
            $table->unique(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

