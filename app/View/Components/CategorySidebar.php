<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class CategorySidebar extends Component
{
    public $categories;
    public $activeCategory;
    public $activeSubcategory;

    public function __construct($activeCategory = null, $activeSubcategory = null)
    {
        $this->categories = Category::with(['subcategories' => function ($query) {
                $query->active()->ordered();
            }])
            ->active()
            ->ordered()
            ->get();

        $this->activeCategory = $activeCategory;
        $this->activeSubcategory = $activeSubcategory;
    }

    public function render()
    {
        return view('components.category-sidebar');
    }
}
