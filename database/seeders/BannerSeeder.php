<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the banner directory exists
        $bannerPath = public_path('images/banner');
        if (!file_exists($bannerPath)) {
            mkdir($bannerPath, 0777, true);
        }

        // Sample banner data
        $banners = [
            [
                'title' => 'Summer Collection 2025',
                'subtitle' => 'Up to 50% Off',
                'button_text' => 'Shop Now',
                'button_url' => '/products?category=summer-collection',
                'image' => '/images/banner/banner-1.png',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'New Arrivals',
                'subtitle' => 'Discover the Latest Trends',
                'button_text' => 'View Collection',
                'button_url' => '/new-arrivals',
                'image' => '/images/banner/banner-2.png',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Limited Time Offer',
                'subtitle' => 'Free Shipping on Orders Over $50',
                'button_text' => 'Shop Now',
                'button_url' => '/products?on_sale=true',
                'image' => '/images/banner/banner-3.png',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

    
    }
}
