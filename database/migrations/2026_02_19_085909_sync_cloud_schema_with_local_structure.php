<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | FIX applications
        |--------------------------------------------------------------------------
        */

        // Drop unique index di user_id jika ada
        try {
            Schema::table('applications', function (Blueprint $table) {
                $table->dropUnique(['user_id']);
            });
        } catch (\Exception $e) {
            // ignore jika tidak ada
        }

        // Update ENUM status
        DB::statement("
            ALTER TABLE applications 
            MODIFY status ENUM(
                'diproses',
                'screening',
                'seleksi',
                'tidak_lolos_saw',
                'interview',
                'offer',
                'offer_ditolak',
                'ditolak_administrasi',
                'diterima',
                'ditolak'
            ) NOT NULL DEFAULT 'diproses'
        ");

        /*
        |--------------------------------------------------------------------------
        | FIX lowongans
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE lowongans 
            MODIFY tipe_kerja VARCHAR(20) NOT NULL
        ");

        DB::statement("
            ALTER TABLE lowongans 
            MODIFY jenis_kelamin ENUM(
                'laki-laki',
                'perempuan',
                'semua'
            ) DEFAULT NULL
        ");

        /*
        |--------------------------------------------------------------------------
        | FIX pelamar_profiles
        |--------------------------------------------------------------------------
        */

        // Rename kolom agar sama dengan local
        DB::statement("ALTER TABLE pelamar_profiles CHANGE whatsapp phone VARCHAR(30) NULL");
        DB::statement("ALTER TABLE pelamar_profiles CHANGE lokasi location VARCHAR(255) NULL");
        DB::statement("ALTER TABLE pelamar_profiles CHANGE usia age SMALLINT NULL");
        DB::statement("ALTER TABLE pelamar_profiles CHANGE pendidikan_terakhir last_education VARCHAR(255) NULL");

        // Tambah kolom photo jika belum ada
        if (!Schema::hasColumn('pelamar_profiles', 'photo')) {
            Schema::table('pelamar_profiles', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('user_id');
            });
        }

        // Drop kolom pengalaman_singkat jika ada
        if (Schema::hasColumn('pelamar_profiles', 'pengalaman_singkat')) {
            Schema::table('pelamar_profiles', function (Blueprint $table) {
                $table->dropColumn('pengalaman_singkat');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FIX pelamar_educations
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pelamar_educations', 'mulai_bulan')) {
            Schema::table('pelamar_educations', function (Blueprint $table) {
                $table->tinyInteger('mulai_bulan')->nullable()->after('mulai_tahun');
            });
        }
    }

    public function down(): void
    {
        // Tidak dibuat rollback karena ini migration sinkronisasi production
    }
};
