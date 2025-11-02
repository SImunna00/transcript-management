<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksheetsTable extends Migration
{
    public function up()
    {
        Schema::create('marksheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('session');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->decimal('tgpa', 3, 2);
            $table->decimal('cgpa', 3, 2);
            $table->integer('credits_completed');
            $table->integer('total_credits');
            $table->integer('cumulative_credits');
            $table->integer('total_cumulative_credits');
            $table->timestamp('generated_at')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users'); // Admin who generated
            $table->enum('status', ['draft', 'approved', 'published'])->default('draft');
            $table->timestamps();

            // Ensure unique marksheet per student, session, year, and term
            $table->unique(['user_id', 'session', 'academic_year_id', 'term_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('marksheets');
    }
}
