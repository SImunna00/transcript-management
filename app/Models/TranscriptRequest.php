<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TranscriptRequest extends Model
{
    use HasFactory;

    protected $table = 'transcript_requests'; // Ensure this is the correct table name

    protected $fillable = [
        'user_id',
        'academic_year',
        'term',
        'session', // Added for session info
        'additional_info',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_id',
        'result_file',
        'transcript_path', // If this field exists
        'status', // If this field exists
        'uploaded_at', // If this field exists
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

