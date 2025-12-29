<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelamar_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->unique(); // 1 user = 1 profile

            $table->string('whatsapp')->nullable();
            $table->string('lokasi')->nullable();
            $table->unsignedSmallInteger('usia')->nullable();

            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('pendidikan_terakhir')->nullable();

            $table->text('tentang_saya')->nullable();
            $table->text('pengalaman_singkat')->nullable(); // jika kamu ingin ringkasan pengalaman pada card atas

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelamar_profiles');
    }
};
