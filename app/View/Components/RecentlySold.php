<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;
use App\Models\OrderItem;

class RecentlySold extends Component
{
    public $recentlySoldProducts;
    public $countdownEndTime;
    public $processedProducts;

    public function __construct()
    {
        // Get recently sold products based on order items
        $this->recentlySoldProducts = $this->getRecentlySoldProducts();
        
        // Set countdown end time (you can make this dynamic based on campaigns)
        $this->countdownEndTime = $this->getCountdownEndTime();
        
        // Process products with calculated values
        $this->processedProducts = $this->getProcessedProducts();
    }

    /**
     * Get processed products with calculated values
     */
    private function getProcessedProducts()
    {
        return $this->recentlySoldProducts->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });
    }

    /**
     * Get recently sold products from order items
     */
    private function getRecentlySoldProducts()
    {
        // Get products that have been sold recently (last 30 days)
        $recentlySoldProductIds = OrderItem::whereHas('order', function($query) {
                $query->where('created_at', '>=', now()->subDays(30))
                      ->where('status', '!=', 'cancelled');
            })
            ->selectRaw('product_id, COUNT(*) as sold_count')
            ->groupBy('product_id')
            ->orderBy('sold_count', 'desc')
            ->limit(8) // Get top 8 most sold products
            ->pluck('product_id');

        // If we have recently sold products, return them
        if ($recentlySoldProductIds->count() > 0) {
            return Product::with(['images', 'variants'])
                ->whereIn('id', $recentlySoldProductIds)
                ->where('is_active', true)
                ->get()
                ->sortBy(function($product) use ($recentlySoldProductIds) {
                    return array_search($product->id, $recentlySoldProductIds->toArray());
                });
        }

        // Fallback: Show featured products or recent products if no sales yet
        return Product::with(['images', 'variants'])
            ->where('is_active', true)
            ->where(function($query) {
                $query->where('is_featured', true)
                      ->orWhere('created_at', '>=', now()->subDays(7)); // Recent products
            })
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
    }

    /**
     * Get countdown end time for the sale
     */
    private function getCountdownEndTime()
    {
        // You can make this dynamic based on active campaigns
        // For now, setting it to 2 days from now
        return now()->addDays(2)->addHours(18)->addMinutes(53)->addSeconds(14);
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
        return view('components.product-sections.recently-sold');
    }
}
