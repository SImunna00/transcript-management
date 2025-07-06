<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'academic_year',
        'term',
        'attendance',
        'class_test',
        'mid_term',
        'final',
        'viva',
        'total_marks',
        'grade_point',
        'letter_grade',
        'result_file',
        'submitted_by',
        'approved',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'approved' => 'boolean',
        'approved_at' => 'datetime',
        'total_marks' => 'float',
        'grade_point' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'submitted_by');
    }

    public function approver()
    {
        // Assuming admin approves results and admin is a separate model
        // You might need to adjust this based on your admin model
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Calculate grade based on total marks
    public function calculateGrade()
    {
        $totalMarks = $this->attendance + $this->class_test +
            $this->mid_term + $this->final + $this->viva;

        $this->total_marks = $totalMarks;

        // Grade calculation based on typical university grading system
        if ($totalMarks >= 80) {
            $this->grade_point = 4.00;
            $this->letter_grade = 'A+';
        } elseif ($totalMarks >= 75) {
            $this->grade_point = 3.75;
            $this->letter_grade = 'A';
        } elseif ($totalMarks >= 70) {
            $this->grade_point = 3.50;
            $this->letter_grade = 'A-';
        } elseif ($totalMarks >= 65) {
            $this->grade_point = 3.25;
            $this->letter_grade = 'B+';
        } elseif ($totalMarks >= 60) {
            $this->grade_point = 3.00;
            $this->letter_grade = 'B';
        } elseif ($totalMarks >= 55) {
            $this->grade_point = 2.75;
            $this->letter_grade = 'B-';
        } elseif ($totalMarks >= 50) {
            $this->grade_point = 2.50;
            $this->letter_grade = 'C+';
        } elseif ($totalMarks >= 45) {
            $this->grade_point = 2.25;
            $this->letter_grade = 'C';
        } elseif ($totalMarks >= 40) {
            $this->grade_point = 2.00;
            $this->letter_grade = 'D';
        } else {
            $this->grade_point = 0.00;
            $this->letter_grade = 'F';
        }

        return $this;
    }
}
