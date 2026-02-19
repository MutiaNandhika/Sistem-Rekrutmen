<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Drop foreign key dulu
            $table->dropForeign(['user_id']);
        });

        // Drop unique index
        DB::statement("ALTER TABLE applications DROP INDEX applications_user_id_unique");

        Schema::table('applications', function (Blueprint $table) {
            // Tambahkan kembali foreign key TANPA unique
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        DB::statement("ALTER TABLE applications ADD UNIQUE (user_id)");

        Schema::table('applications', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }
};
