<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelamar_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_skill');

            $table->timestamps();

            $table->unique(['user_id', 'nama_skill']); // biar ga dobel
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelamar_skills');
    }
};
