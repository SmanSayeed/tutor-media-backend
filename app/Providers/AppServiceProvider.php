<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Blade::components([
            'hero-slider' => \App\View\Components\HeroSlider::class,
            'category-sidebar' => \App\View\Components\CategorySidebar::class,
            'featured-products' => \App\View\Components\FeaturedProducts::class,
            'all-products' => \App\View\Components\AllProducts::class,
            'nav-drawer' => \App\View\Components\NavDrawer::class,
        ]);
    }
}
