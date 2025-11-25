<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class NavDrawer extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::with(['subcategories' => function ($query) {
                $query->where('is_active', true)->orderBy('name');
            }])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('components.nav-drawer');
    }
}
