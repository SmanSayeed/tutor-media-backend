<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',    
        'size_id',
        'color_id',
        'stock_quantity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function scopeWithProduct($query)
    {
        return $query->with(['product', 'size']);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")            
              ->orWhereHas('product', function($productQuery) use ($search) {
                  $productQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status === 'active') {
            return $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            return $query->where('is_active', false);
        }
        return $query;
    }

    public function scopeFilterByStock($query, $stockFilter)
    {
        switch ($stockFilter) {
            case 'in_stock':
                return $query->where('stock_quantity', '>', 0);
            case 'out_of_stock':
                return $query->where('stock_quantity', '<=', 0);
            case 'low_stock':
                return $query->where('stock_quantity', '>', 0)
                           ->whereRaw('stock_quantity <= (SELECT min_stock_level FROM products WHERE products.id = product_variants.product_id)');
            default:
                return $query;
        }
    }

    public function getDisplayNameAttribute()
    {
        $parts = [$this->name];

        if ($this->size) {
            $parts[] = $this->size->name;
        }

        return implode(' - ', $parts);
    }
}
