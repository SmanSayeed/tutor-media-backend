<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'child_category_id',
        'brand_id',
        'color_id',
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'main_image',
        'video_url',
        'price',
        'sale_price',
        'cost_price',
        'features',
        'specifications',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_featured',
        'view_count',
        'sales_count',
        'sale_start_date',
        'sale_end_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'features' => 'array',
        'specifications' => 'array',
        'meta_keywords' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function childCategory(): BelongsTo
    {
        return $this->belongsTo(ChildCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        // First check if product has a main_image set
        if ($this->main_image) {
            return $this->main_image;
        }

        // Otherwise, get the first primary image from product_images table
        return $this->images()->primary()->first()?->image_path;
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('track_inventory', false)
                    ->orWhereHas('variants', function($q) {
                        $q->where('stock_quantity', '>', 0);
                    });
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')
                    ->where('sale_start_date', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('sale_end_date')
                          ->orWhere('sale_end_date', '>=', now());
                    });
    }

    public function getCurrentPriceAttribute()
    {
        if ($this->isOnSale()) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->isOnSale() && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function isOnSale()
    {
        return $this->sale_price &&
               $this->sale_start_date <= now() &&
               ($this->sale_end_date === null || $this->sale_end_date >= now());
    }

    public function isInStock()
    {
        if (!$this->track_inventory) {
            return true;
        }
        return $this->variants()->where('stock_quantity', '>', 0)->exists();
    }

    public function isLowStock()
    {
        if (!$this->track_inventory) {
            return false;
        }
        return $this->variants()
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $this->min_stock_level)
            ->exists();
    }

    public function totalStock()
    {
        return $this->variants()->sum('stock_quantity');
    }

    public function availableVariants()
    {
        return $this->variants()->where('stock_quantity', '>', 0)->get();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'brand' => $this->brand?->name,
            'category' => $this->category?->name,
            'subcategory' => $this->subcategory?->name,
            'child_category' => $this->childCategory?->name,
            'color' => $this->color?->name,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
        ];
    }
}
