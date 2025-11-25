<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CookieConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'necessary',
        'functional',
        'analytics',
        'marketing',
        'preferences',
        'ip_address',
        'user_agent',
        'consent_date',
    ];

    protected $casts = [
        'necessary' => 'boolean',
        'functional' => 'boolean',
        'analytics' => 'boolean',
        'marketing' => 'boolean',
        'preferences' => 'array',
        'consent_date' => 'datetime',
    ];
}
