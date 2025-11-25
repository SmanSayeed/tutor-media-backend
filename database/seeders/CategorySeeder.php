<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Men\'s Shoes',
                'slug' => 'mens-shoes',
                'description' => 'Discover our extensive collection of men\'s footwear including sneakers, dress shoes, boots, and casual shoes.',
                'image' => 'images/categories/mens-shoes.jpg',
                'meta_title' => 'Men\'s Shoes | Premium Footwear Collection',
                'meta_description' => 'Shop the latest collection of men\'s shoes including sneakers, dress shoes, boots, and casual footwear. Find your perfect pair today.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Women\'s Shoes',
                'slug' => 'womens-shoes',
                'description' => 'Explore our stylish collection of women\'s footwear featuring heels, flats, sneakers, boots, and sandals.',
                'image' => 'images/categories/womens-shoes.jpg',
                'meta_title' => 'Women\'s Shoes | Fashionable Footwear Collection',
                'meta_description' => 'Browse our trendy collection of women\'s shoes including heels, flats, sneakers, boots, and sandals. Step out in style.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Kids\' Shoes',
                'slug' => 'kids-shoes',
                'description' => 'Find comfortable and durable shoes for children including school shoes, sneakers, and casual footwear.',
                'image' => 'images/categories/kids-shoes.jpg',
                'meta_title' => 'Kids\' Shoes | Comfortable Children\'s Footwear',
                'meta_description' => 'Shop our collection of kids\' shoes including school shoes, sneakers, and casual footwear. Comfort and durability guaranteed.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sports & Athletic',
                'slug' => 'sports-athletic',
                'description' => 'Performance-driven athletic footwear for running, training, basketball, and all sports activities.',
                'image' => 'images/categories/sports-shoes.jpg',
                'meta_title' => 'Sports & Athletic Shoes | Performance Footwear',
                'meta_description' => 'Gear up with our sports and athletic shoes collection. Perfect for running, training, and all your athletic needs.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Casual Shoes',
                'slug' => 'casual-shoes',
                'description' => 'Comfortable everyday footwear including loafers, slip-ons, canvas shoes, and casual sneakers.',
                'image' => 'images/categories/casual-shoes.jpg',
                'meta_title' => 'Casual Shoes | Comfortable Everyday Footwear',
                'meta_description' => 'Discover comfortable casual shoes including loafers, slip-ons, and sneakers perfect for everyday wear.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Formal Shoes',
                'slug' => 'formal-shoes',
                'description' => 'Elegant formal footwear including dress shoes, oxfords, loafers, and professional shoes.',
                'image' => 'images/categories/formal-shoes.jpg',
                'meta_title' => 'Formal Shoes | Professional & Dress Footwear',
                'meta_description' => 'Elevate your professional look with our formal shoes collection including dress shoes and oxfords.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Boots & Ankle Boots',
                'slug' => 'boots-ankle-boots',
                'description' => 'Stylish boots and ankle boots for all seasons including combat boots, chelsea boots, and fashion boots.',
                'image' => 'images/categories/boots.jpg',
                'meta_title' => 'Boots & Ankle Boots | Stylish Footwear',
                'meta_description' => 'Complete your look with our boots and ankle boots collection featuring combat boots, chelsea boots, and more.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Sandals & Flip Flops',
                'slug' => 'sandals-flip-flops',
                'description' => 'Comfortable summer footwear including sandals, flip flops, slides, and beach shoes.',
                'image' => 'images/categories/sandals.jpg',
                'meta_title' => 'Sandals & Flip Flops | Summer Footwear',
                'meta_description' => 'Stay cool with our sandals and flip flops collection perfect for summer and beach activities.',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
