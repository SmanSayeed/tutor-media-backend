<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display all active categories in a grid.
     */
    public function index()
    {
        $categories = Category::active()
            ->ordered()
            ->get(['id', 'name', 'slug', 'description', 'image', 'meta_description']);

        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its products and subcategories
     */
    public function show(Category $category)
    {
        abort_unless($category->is_active, 404);

        $category->load(['subcategories' => function ($query) {
            $query->where('is_active', true)
                ->orderBy('name')
                ->withCount('products');
        }]);

        $products = Product::with(['images', 'variants', 'category', 'brand', 'subcategory'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get all active categories for the sidebar
        $categories = Category::with(['subcategories' => function($query) {
            $query->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)
          ->orderBy('name')
          ->get();

        return view('frontend.categories.show', [
            'category' => $category,
            'subcategory' => null,
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $category->id,
            'activeSubcategory' => null
        ]);
    }
}
