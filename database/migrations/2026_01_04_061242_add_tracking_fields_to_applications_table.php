<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {

            // ===============================
            // INTERVIEW
            // ===============================
            $table->timestamp('interview_at')->nullable()->after('status');
            $table->string('interview_method')->nullable()->after('interview_at');
            $table->string('interview_link')->nullable()->after('interview_method');

            // ===============================
            // OFFER
            // ===============================
            $table->string('offer_file')->nullable()->after('interview_link');
            $table->enum('offer_response', ['diterima', 'ditolak'])
                  ->nullable()
                  ->after('offer_file');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'interview_at',
                'interview_method',
                'interview_link',
                'offer_file',
                'offer_response',
            ]);
        });
    }
};
