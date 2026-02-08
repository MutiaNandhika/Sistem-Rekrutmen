<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('pelamar_certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('pelamar_certificates', 'file_bukti')) {
                $table->string('file_bukti')->after('informasi_tambahan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelamar_certificates', function (Blueprint $table) {
            if (Schema::hasColumn('pelamar_certificates', 'file_bukti')) {
                $table->dropColumn('file_bukti');
            }
        });
    }
};
