<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add academic year and term if they don't exist
            if (!Schema::hasColumn('users', 'academic_year_id')) {
                $table->foreignId('academic_year_id')->nullable()->after('session')->constrained('academic_years')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'term_id')) {
                $table->foreignId('term_id')->nullable()->after('academic_year_id')->constrained('terms')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['term_id']);
            $table->dropColumn(['academic_year_id', 'term_id']);
        });
    }
};
