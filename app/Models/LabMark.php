<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabMark extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'academic_year_id',
        'term_id',
        'session',
        'attendance',
        'report',
        'lab_work',
        'viva',
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
        return TheoryMark::calculateGradeFromTotal($total);
    }
}
