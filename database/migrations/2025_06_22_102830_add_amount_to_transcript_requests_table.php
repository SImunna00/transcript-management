<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transcript_requests', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable()->after('additional_info');
        });
    }

    public function down()
    {
        Schema::table('transcript_requests', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }

};
