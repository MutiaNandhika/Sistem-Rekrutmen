<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('pelamar_skills', function (Blueprint $table) {

            // 1. Tambah skill_id
            if (!Schema::hasColumn('pelamar_skills', 'skill_id')) {
                $table->unsignedBigInteger('skill_id')->after('user_id');
            }
        });

        Schema::table('pelamar_skills', function (Blueprint $table) {

            // 2. Hapus unique lama (user_id + nama_skill)
            try {
                $table->dropUnique(['user_id', 'nama_skill']);
            } catch (\Throwable $e) {
                // abaikan kalau tidak ada
            }

            // 3. Hapus kolom nama_skill
            if (Schema::hasColumn('pelamar_skills', 'nama_skill')) {
                $table->dropColumn('nama_skill');
            }
        });

        Schema::table('pelamar_skills', function (Blueprint $table) {

            // 4. Foreign key ke skills
            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->cascadeOnDelete();

            // 5. Unique baru
            $table->unique(['user_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::table('pelamar_skills', function (Blueprint $table) {

            $table->dropForeign(['skill_id']);
            $table->dropUnique(['user_id', 'skill_id']);

            $table->string('nama_skill')->after('user_id');
            $table->dropColumn('skill_id');
        });
    }
};
