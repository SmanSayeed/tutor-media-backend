<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'banner_image',
        'type',
        'discount_percentage',
        'discount_amount',
        'minimum_amount',
        'applicable_products',
        'applicable_categories',
        'start_date',
        'end_date',
        'is_active',
        'usage_limit',
        'usage_count',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = Str::slug($campaign->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    public function isActive()
    {
        return $this->is_active &&
               $this->start_date <= now() &&
               ($this->end_date === null || $this->end_date >= now());
    }

    public function canBeUsed()
    {
        return $this->isActive() &&
               ($this->usage_limit === null || $this->usage_count < $this->usage_limit);
    }
}
