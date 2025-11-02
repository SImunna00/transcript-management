<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marksheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session',
        'academic_year_id',
        'term_id',
        'tgpa',
        'cgpa',
        'credits_completed',
        'total_credits',
        'cumulative_credits',
        'total_cumulative_credits',
        'generated_at',
        'generated_by',
        'status',
        'file_path',
        'pdf_filename'
    ];

    protected $casts = [
        'generated_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function getYearTermDisplayAttribute()
    {
        return $this->academicYear->name . ' Year ' . $this->term->name . ' Term';
    }

    // Get all marks for this marksheet - including failed courses
    public function getAllMarks()
    {
        $courses = Course::where('academic_year_id', $this->academic_year_id)
            ->where('term_id', $this->term_id)
            ->get();

        $allMarks = collect();

        foreach ($courses as $course) {
            $markFound = false;

            // Check theory marks
            $theoryMark = TheoryMark::where('user_id', $this->user_id)
                ->where('course_id', $course->id)
                ->where('session', $this->session)
                ->first();

            if ($theoryMark) {
                $allMarks->push((object) [
                    'course' => $course,
                    'total_marks' => $theoryMark->total,
                    'grade_point' => $theoryMark->grade_point,
                    'grade' => $theoryMark->grade,
                    'type' => 'theory'
                ]);
                $markFound = true;
            }

            // Check lab marks
            $labMark = LabMark::where('user_id', $this->user_id)
                ->where('course_id', $course->id)
                ->where('session', $this->session)
                ->first();

            if ($labMark) {
                $allMarks->push((object) [
                    'course' => $course,
                    'total_marks' => $labMark->total,
                    'grade_point' => $labMark->grade_point,
                    'grade' => $labMark->grade,
                    'type' => 'lab'
                ]);
                $markFound = true;
            }

            // Check special marks
            $specialMark = SpecialMark::where('user_id', $this->user_id)
                ->where('course_id', $course->id)
                ->where('session', $this->session)
                ->first();

            if ($specialMark) {
                $allMarks->push((object) [
                    'course' => $course,
                    'total_marks' => $specialMark->total,
                    'grade_point' => $specialMark->grade_point,
                    'grade' => $specialMark->grade,
                    'type' => 'special'
                ]);
                $markFound = true;
            }

            // If no marks found for this course, show it as incomplete/failed
            if (!$markFound) {
                $allMarks->push((object) [
                    'course' => $course,
                    'total_marks' => 0,
                    'grade_point' => 0.00,
                    'grade' => 'I', // I for Incomplete, or could be 'F' for Fail
                    'type' => 'incomplete'
                ]);
            }
        }

        return $allMarks;
    }
}
