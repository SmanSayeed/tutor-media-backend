<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ProductSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('product-sections.featured-products', 'featured-products');
        Blade::component('product-sections.popular-products', 'popular-products');
        Blade::component('product-sections.all-products', 'all-products');
    }
}