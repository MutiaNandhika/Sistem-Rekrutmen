<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        // DROP TABLE LAMA
        Schema::dropIfExists('pelamar_skills');

        // BUAT ULANG DENGAN STRUKTUR BENAR
        Schema::create('pelamar_skills', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('skill_id');

            $table->timestamps();

            // RELASI
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->cascadeOnDelete();

            // ANTI DUPLIKAT
            $table->unique(['user_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelamar_skills');
    }
};
