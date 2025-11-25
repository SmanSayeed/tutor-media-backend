<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalyticsEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'event_name',
        'event_data',
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'referrer',
        'page_url',
        'customer_id',
        'product_id',
        'order_id',
    ];

    protected $casts = [
        'event_data' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function track($eventType, $eventName, $data = [])
    {
        return static::create([
            'event_type' => $eventType,
            'event_name' => $eventName,
            'event_data' => $data,
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
            'page_url' => request()->fullUrl(),
        ]);
    }
}
