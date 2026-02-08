<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        // 1. Tambah kolom skill_id jika belum ada
        Schema::table('pelamar_skills', function (Blueprint $table) {
            if (!Schema::hasColumn('pelamar_skills', 'skill_id')) {
                $table->unsignedBigInteger('skill_id')->after('user_id');
            }
        });

        // 2. Hapus kolom nama_skill jika masih ada
        Schema::table('pelamar_skills', function (Blueprint $table) {
            if (Schema::hasColumn('pelamar_skills', 'nama_skill')) {
                $table->dropColumn('nama_skill');
            }
        });

        // 3. CEK foreign key via DB
        $fkExists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'pelamar_skills'
              AND COLUMN_NAME = 'skill_id'
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (count($fkExists) === 0) {
            Schema::table('pelamar_skills', function (Blueprint $table) {
                $table->foreign('skill_id')
                    ->references('id')
                    ->on('skills')
                    ->cascadeOnDelete();
            });
        }

        // 4. CEK unique user_id + skill_id
        $uniqueExists = DB::select("
            SHOW INDEX FROM pelamar_skills
            WHERE Key_name = 'pelamar_skills_user_id_skill_id_unique'
        ");

        if (count($uniqueExists) === 0) {
            Schema::table('pelamar_skills', function (Blueprint $table) {
                $table->unique(['user_id', 'skill_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('pelamar_skills', function (Blueprint $table) {

            try {
                $table->dropForeign(['skill_id']);
            } catch (\Throwable $e) {}

            try {
                $table->dropUnique(['user_id', 'skill_id']);
            } catch (\Throwable $e) {}

            if (!Schema::hasColumn('pelamar_skills', 'nama_skill')) {
                $table->string('nama_skill')->after('user_id');
            }

            if (Schema::hasColumn('pelamar_skills', 'skill_id')) {
                $table->dropColumn('skill_id');
            }
        });
    }
};
