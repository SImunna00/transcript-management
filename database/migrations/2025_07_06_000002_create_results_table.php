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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->string('term');

            // Marks components (out of 100 total)
            $table->decimal('attendance', 5, 2)->default(0);     // e.g. 10%
            $table->decimal('class_test', 5, 2)->default(0);     // e.g. 15% 
            $table->decimal('mid_term', 5, 2)->default(0);       // e.g. 25%
            $table->decimal('final', 5, 2)->default(0);          // e.g. 40%
            $table->decimal('viva', 5, 2)->default(0);           // e.g. 10%

            // Calculated results
            $table->decimal('total_marks', 5, 2)->default(0);
            $table->decimal('grade_point', 3, 2)->default(0);
            $table->string('letter_grade')->nullable();

            // Result file
            $table->string('result_file')->nullable();

            // Submission and approval info
            $table->foreignId('submitted_by')->nullable()->constrained('teachers');
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // A student should have only one result per course per term/year
            $table->unique(['user_id', 'course_id', 'academic_year', 'term']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
