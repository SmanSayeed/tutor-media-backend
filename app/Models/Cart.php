<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_price',
        'total_price',
        'product_attributes',
        'is_buy_now',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'product_attributes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        // Ensure both values are strings for bcmul precision
        $this->total_price = (float)bcmul((string)$this->unit_price, (string)$quantity, 2);
        $this->save();
    }

    public function getTotalAttribute()
    {
        // Ensure both values are strings for bcmul precision
        return bcmul((string)$this->unit_price, (string)$this->quantity, 2);
    }
}
