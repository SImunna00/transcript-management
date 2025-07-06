<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'title',
        'credits',
        'department',
    ];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_course')
            ->withPivot('academic_year', 'term')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments')
            ->withPivot('academic_year', 'term')
            ->withTimestamps();
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
