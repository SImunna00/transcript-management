<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'father_name',
        'mother_name',
        'email',
        'studentid',
        'password',
        'phone',
        'photo',
        'session',
        'hall_name',
        'room_number',
        'academic_year_id',
        'term_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the department name (hardcoded as ICE)
     */
    public function getDepartmentAttribute()
    {
        return "ICE Department";
    }

    /**
     * Get the academic year
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the term
     */
    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the theory marks for the student
     */
    public function theoryMarks()
    {
        return $this->hasMany(TheoryMark::class, 'user_id');
    }

    /**
     * Get the lab marks for the student
     */
    public function labMarks()
    {
        return $this->hasMany(LabMark::class, 'user_id');
    }

    /**
     * Get the special marks for the student
     */
    public function specialMarks()
    {
        return $this->hasMany(SpecialMark::class, 'user_id');
    }

    /**
     * Get the semester results for the student
     */


    /**
     * Get the results for the student
     */


}
