<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelamar_organizations', function (Blueprint $table) {
            $table->string('file_bukti')->nullable()->after('informasi_tambahan');
        });
    }

    public function down(): void
    {
        Schema::table('pelamar_organizations', function (Blueprint $table) {
            $table->dropColumn('file_bukti');
        });
    }
};
