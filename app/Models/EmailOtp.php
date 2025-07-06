<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EmailOtp extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public static function generateOtp($email)
    {
        self::where('email', $email)->delete();
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        self::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(15),
        ]);
        return $otp;
    }
}
