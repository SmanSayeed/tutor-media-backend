<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class SpecialItems extends Component
{
    public $specialProducts;
    public $processedProducts;

    public function __construct()
    {
        // Get special products (with sale prices or special flags)
        $this->specialProducts = $this->getSpecialProducts();
        
        // Process products with calculated values
        $this->processedProducts = $this->getProcessedProducts();
    }

    /**
     * Get special products
     */
    private function getSpecialProducts()
    {
        return Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNotNull('sale_price')
                      ->where('sale_price', '<', \DB::raw('price'))
                      ->orWhere('is_featured', true);
            })
            ->orderBy('sale_price', 'asc') // Products with biggest discounts first
            ->orderBy('is_featured', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get processed products with calculated values
     */
    private function getProcessedProducts()
    {
        return $this->specialProducts->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });
    }

    /**
     * Calculate discount percentage
     */
    private function calculateDiscountPercentage($originalPrice, $salePrice)
    {
        if (!$salePrice || $salePrice >= $originalPrice) {
            return 0;
        }
        
        return round((($originalPrice - $salePrice) / $originalPrice) * 100);
    }

    /**
     * Get product rating (you can implement this based on reviews)
     */
    private function getProductRating($product)
    {
        // For now, return a random rating between 3.5 and 5.0
        // You can implement this based on actual reviews later
        return number_format(rand(350, 500) / 100, 1);
    }

    /**
     * Get product image URL
     */
    private function getProductImage($product)
    {
        // First try main_image from product
        if ($product->main_image) {
            return $product->main_image;
        }
        
        // Then try product images relationship
        if ($product->images && $product->images->count() > 0) {
            return $product->images->first()->path;
        }
        
        // Fallback to a default image
        return 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.special-items');
    }
}
