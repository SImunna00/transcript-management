<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transcript_requests', function (Blueprint $table) {
            $table->string('transcript_path')->nullable()->after('transaction_id');
            $table->string('status')->default('pending')->after('payment_status');
            $table->timestamp('uploaded_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transcript_requests', function (Blueprint $table) {
            $table->dropColumn('transcript_path');
            $table->dropColumn('status');
            $table->dropColumn('uploaded_at');
        });
    }
};