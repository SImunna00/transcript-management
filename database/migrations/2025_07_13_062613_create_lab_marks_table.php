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
        Schema::create('lab_marks', function (Blueprint $table) {
           $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade'); // Changed to foreignId
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade'); // Changed to foreignId
            $table->string('session'); // e.g., 2023-2024
            $table->integer('attendance')->default(0);
            $table->integer('report')->default(0);
            $table->integer('lab_work')->default(0);
            $table->integer('viva')->default(0);
            $table->integer('total')->default(0);
            $table->string('grade'); // e.g., A+, B
            $table->decimal('grade_point', 4, 2); // e.g., 4.00
            $table->timestamps();
            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_marks');
    }
};
