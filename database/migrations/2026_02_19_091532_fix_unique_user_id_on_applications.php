<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE applications 
            DROP INDEX applications_user_id_unique
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE applications 
            ADD UNIQUE (user_id)
        ");
    }
};
