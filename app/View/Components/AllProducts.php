<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class AllProducts extends Component
{
    public $allProducts;

    public function __construct()
    {
        // Get all products (limited for homepage display)
        $this->allProducts = $this->getAllProducts();
    }

    /**
     * Get all products
     */
    private function getAllProducts()
    {
        return Product::with(['images', 'variants'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->map(function($product) {
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
    public function calculateDiscountPercentage($originalPrice, $salePrice)
    {
        if (!$salePrice || $salePrice >= $originalPrice) {
            return 0;
        }

        return round((($originalPrice - $salePrice) / $originalPrice) * 100);
    }

    /**
     * Get product rating (you can implement this based on reviews)
     */
    public function getProductRating($product)
    {
        // For now, return a random rating between 3.5 and 5.0
        // You can implement this based on actual reviews later
        return number_format(rand(350, 500) / 100, 1);
    }

    /**
     * Get product image URL
     */
    public function getProductImage($product)
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
        return view('components.product-sections.all-products');
    }
}