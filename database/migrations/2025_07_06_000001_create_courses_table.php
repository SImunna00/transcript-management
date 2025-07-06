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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('title');
            $table->decimal('credits', 3, 1);
            $table->string('department');
            $table->timestamps();
        });

        Schema::create('teacher_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->string('term');
            $table->timestamps();

            // A teacher shouldn't be assigned to the same course twice in the same term/year
            $table->unique(['teacher_id', 'course_id', 'academic_year', 'term']);
        });

        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->string('term');
            $table->timestamps();

            // A student shouldn't be enrolled in the same course twice in the same term/year
            $table->unique(['user_id', 'course_id', 'academic_year', 'term']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
        Schema::dropIfExists('teacher_course');
        Schema::dropIfExists('courses');
    }
};
