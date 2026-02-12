<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {

            // ===== SNAPSHOT IDENTITAS =====
            $table->string('snap_name')->nullable();
            $table->string('snap_email')->nullable();
            $table->string('snap_phone')->nullable();
            $table->string('snap_location')->nullable();
            $table->integer('snap_age')->nullable();
            $table->string('snap_gender')->nullable();
            $table->string('snap_last_education')->nullable();
            $table->string('snap_photo')->nullable();
            $table->text('snap_about')->nullable();

            // ===== SNAPSHOT SAW =====
            $table->integer('snap_pendidikan_nilai')->nullable();
            $table->float('snap_pengalaman_tahun')->nullable();
            $table->integer('snap_total_skill')->nullable();

            // ===== SNAPSHOT JSON DATA LENGKAP =====
            $table->json('snap_experiences')->nullable();
            $table->json('snap_educations')->nullable();
            $table->json('snap_skills')->nullable();
            $table->json('snap_certificates')->nullable();
            $table->json('snap_organizations')->nullable();
            $table->json('snap_achievements')->nullable();
            $table->json('snap_resume')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'snap_name',
                'snap_email',
                'snap_phone',
                'snap_location',
                'snap_age',
                'snap_gender',
                'snap_last_education',
                'snap_photo',
                'snap_about',
                'snap_pendidikan_nilai',
                'snap_pengalaman_tahun',
                'snap_total_skill',
                'snap_experiences',
                'snap_educations',
                'snap_skills',
                'snap_certificates',
                'snap_organizations',
                'snap_achievements',
                'snap_resume',
            ]);
        });
    }
};
