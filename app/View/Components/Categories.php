<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class Categories extends Component
{
    public $categories;
    public $processedCategories;

    public function __construct()
    {
        // Get categories
        $this->categories = $this->getCategories();
        
        // Process categories with calculated values
        $this->processedCategories = $this->getProcessedCategories();
    }

    /**
     * Get categories
     */
    private function getCategories()
    {
        return Category::with(['subcategories'])
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->limit(4)
            ->get();
    }

    /**
     * Get processed categories with calculated values
     */
    private function getProcessedCategories()
    {
        return $this->categories->map(function($category) {
            return [
                'category' => $category,
                'image' => $this->getCategoryImage($category),
                'subcategoryText' => $this->getSubcategoryText($category),
                'gradientClass' => $this->getGradientClass($category),
            ];
        });
    }

    /**
     * Get category image
     */
    private function getCategoryImage($category)
    {
        // You can add image field to categories table later
        // For now, use default images based on category name
        $defaultImages = [
            'men' => 'https://images.unsplash.com/photo-1542060748-10c28b62716f?q=80&w=500&auto=format&fit=crop',
            'women' => 'https://images.unsplash.com/photo-1542060748-10c28b62716f?q=80&w=500&auto=format&fit=crop',
            'bag' => 'https://images.unsplash.com/photo-1520975916090-3105956dac38?q=80&w=500&auto=format&fit=crop',
            'belt' => 'https://images.unsplash.com/photo-1578898887932-2b2bbd903586?q=80&w=500&auto=format&fit=crop',
            'wallet' => 'https://images.unsplash.com/photo-1591375275159-95f21d67f113?q=80&w=500&auto=format&fit=crop',
        ];

        $categoryName = strtolower($category->name);
        foreach ($defaultImages as $key => $image) {
            if (str_contains($categoryName, $key)) {
                return $image;
            }
        }

        // Default fallback
        return 'https://images.unsplash.com/photo-1542060748-10c28b62716f?q=80&w=500&auto=format&fit=crop';
    }

    /**
     * Get subcategory text
     */
    private function getSubcategoryText($category)
    {
        if ($category->subcategories && $category->subcategories->count() > 0) {
            $subcategoryNames = $category->subcategories->take(2)->pluck('name')->toArray();
            return implode(' · ', $subcategoryNames);
        }

        // Default subcategory text based on category name
        $defaultSubcategories = [
            'men' => 'Oxfords · Loafers',
            'women' => 'Heels · Flats',
            'bag' => 'Totes · Messenger',
            'belt' => 'Formal · Casual',
            'wallet' => 'Minimal · RFID',
        ];

        $categoryName = strtolower($category->name);
        foreach ($defaultSubcategories as $key => $text) {
            if (str_contains($categoryName, $key)) {
                return $text;
            }
        }

        return 'Products · Accessories';
    }

    /**
     * Get gradient class for category
     */
    private function getGradientClass($category)
    {
        $gradients = [
            'from-rose-100 to-rose-200',
            'from-amber-100 to-amber-200',
            'from-sky-100 to-sky-200',
            'from-emerald-100 to-emerald-200',
        ];

        $index = $category->id % count($gradients);
        return $gradients[$index];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.categories');
    }
}
