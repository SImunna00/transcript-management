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
        'additional_info',
        'amount', // Add this
        'payment_status',
        'payment_method',
        'transaction_id',
    ];

}

