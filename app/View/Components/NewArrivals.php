<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class NewArrivals extends Component
{
    public $newProducts;
    public $processedProducts;

    public function __construct()
    {
        // Get new products (created in the last 30 days)
        $this->newProducts = $this->getNewProducts();
        
        // Process products with calculated values
        $this->processedProducts = $this->getProcessedProducts();
    }

    /**
     * Get new products
     */
    private function getNewProducts()
    {
        return Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get processed products with calculated values
     */
    private function getProcessedProducts()
    {
        return $this->newProducts->map(function($product) {
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
        return view('components.new-arrivals');
    }
}
