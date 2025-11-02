<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheoryMark extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'academic_year_id',
        'term_id',
        'session',
        'participation',
        'ct',
        'semester_final',
        'total',
        'grade',
        'grade_point'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public static function calculateGradeFromTotal($total)
    {
        if ($total >= 80) return ['grade' => 'A+', 'point' => 4.00];
        if ($total >= 75) return ['grade' => 'A', 'point' => 3.75];
        if ($total >= 70) return ['grade' => 'A-', 'point' => 3.50];
        if ($total >= 65) return ['grade' => 'B+', 'point' => 3.25];
        if ($total >= 60) return ['grade' => 'B', 'point' => 3.00];
        if ($total >= 55) return ['grade' => 'B-', 'point' => 2.75];
        if ($total >= 50) return ['grade' => 'C+', 'point' => 2.50];
        if ($total >= 45) return ['grade' => 'C', 'point' => 2.00];
        if ($total >= 40) return ['grade' => 'D', 'point' => 1.00];
        return ['grade' => 'F', 'point' => 0.00];
    }
}
