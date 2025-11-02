<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'phone',
        'photo',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Department is now a text field, no relationship needed

    /**
     * Get the courses assigned to this teacher
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'teacher_course')
            ->withPivot('academic_year', 'term')
            ->withTimestamps();
    }

    /**
     * Get current courses for a specific academic year and term
     * 
     * @param string $academicYear
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function currentCourses(string $academicYear, string $term)
    {
        return $this->courses()
            ->wherePivot('academic_year', $academicYear)
            ->wherePivot('term', $term)
            ->get();
    }
}
