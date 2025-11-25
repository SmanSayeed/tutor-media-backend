<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsAppChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'customer_name',
        'message',
        'status',
        'admin_reply',
        'admin_id',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }
}
