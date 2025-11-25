<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'countries',
        'states',
        'cities',
        'postal_codes',
        'base_rate',
        'free_shipping_threshold',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'countries' => 'array',
        'states' => 'array',
        'cities' => 'array',
        'postal_codes' => 'array',
        'base_rate' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function calculateShipping($orderTotal)
    {
        if ($this->free_shipping_threshold && $orderTotal >= $this->free_shipping_threshold) {
            return 0;
        }
        return $this->base_rate;
    }
}
