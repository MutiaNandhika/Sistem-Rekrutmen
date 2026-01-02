<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lowongan_skill', function (Blueprint $table) {
        $table->id();

        $table->foreignId('lowongan_id')
            ->constrained('lowongans')
            ->cascadeOnDelete();

        $table->foreignId('skill_id')
            ->constrained('skills')
            ->cascadeOnDelete();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_skill');
    }
};
