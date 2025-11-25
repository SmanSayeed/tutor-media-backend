<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class HeroSlider extends Component
{
    public $products;

    public function __construct()
    {
        $this->products = Product::with('images')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNotNull('main_image')
                  ->orWhereHas('images');
            })
            ->latest()
            ->take(3)
            ->get();
            //dd();
    }


    public function render()
    {
        return view('components.hero-slider', [
            'products' => $this->products

        ]);

    }
}
