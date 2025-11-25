<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product
     */
    public function show($slug = null)
    {
        if (!$slug) {
            // If no slug provided, redirect to home
            return redirect()->route('home');
        }

        // Find product by slug
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'images',
                'variants' => function($query) {
                    $query->with(['color', 'size']);
                },
                'category',
                'subcategory',
                'childCategory',
                'brand'
            ])
            ->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('product.show', compact('product'));
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        return view('product.checkout');
    }

    /**
     * Get product data via AJAX
     */
    public function getProductData($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'current_price' => $product->current_price,
            'is_on_sale' => $product->isOnSale(),
            'discount_percentage' => $product->discount_percentage,
            'images' => $product->images->pluck('image_path'),
            'main_image' => $product->main_image,
        ]);
    }
}
