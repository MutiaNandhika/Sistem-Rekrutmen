<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('pelamar_educations', function (Blueprint $table) {
        $table->string('file_bukti')->nullable()->after('informasi_tambahan');
    });
}

public function down()
{
    Schema::table('pelamar_educations', function (Blueprint $table) {
        $table->dropColumn('file_bukti');
    });
}

};
