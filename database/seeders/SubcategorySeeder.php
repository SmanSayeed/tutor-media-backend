<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            // Men's Shoes Subcategories
            [
                'category_slug' => 'mens-shoes',
                'name' => 'Sneakers',
                'slug' => 'mens-sneakers',
                'description' => 'Trendy men\'s sneakers for casual and athletic wear.',
                'image' => 'images/subcategories/mens-sneakers.jpg',
                'meta_title' => 'Men\'s Sneakers | Casual & Athletic',
                'meta_description' => 'Shop men\'s sneakers for casual and athletic wear. Comfortable and stylish options available.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'mens-shoes',
                'name' => 'Dress Shoes',
                'slug' => 'mens-dress-shoes',
                'description' => 'Professional men\'s dress shoes for office and formal occasions.',
                'image' => 'images/subcategories/mens-dress-shoes.jpg',
                'meta_title' => 'Men\'s Dress Shoes | Professional Footwear',
                'meta_description' => 'Find the perfect pair of men\'s dress shoes for office and formal occasions.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'mens-shoes',
                'name' => 'Casual Shoes',
                'slug' => 'mens-casual-shoes',
                'description' => 'Comfortable men\'s casual shoes for everyday wear.',
                'image' => 'images/subcategories/mens-casual-shoes.jpg',
                'meta_title' => 'Men\'s Casual Shoes | Everyday Comfort',
                'meta_description' => 'Discover comfortable men\'s casual shoes perfect for everyday wear.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'category_slug' => 'mens-shoes',
                'name' => 'Boots',
                'slug' => 'mens-boots',
                'description' => 'Durable men\'s boots for work and outdoor activities.',
                'image' => 'images/subcategories/mens-boots.jpg',
                'meta_title' => 'Men\'s Boots | Work & Outdoor',
                'meta_description' => 'Shop durable men\'s boots for work, hiking, and outdoor activities.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'category_slug' => 'mens-shoes',
                'name' => 'Sandals',
                'slug' => 'mens-sandals',
                'description' => 'Comfortable men\'s sandals for summer and casual wear.',
                'image' => 'images/subcategories/mens-sandals.jpg',
                'meta_title' => 'Men\'s Sandals | Summer Comfort',
                'meta_description' => 'Stay comfortable in summer with our men\'s sandals collection.',
                'is_active' => true,
                'sort_order' => 5,
            ],

            // Women's Shoes Subcategories
            [
                'category_slug' => 'womens-shoes',
                'name' => 'High Heels',
                'slug' => 'womens-high-heels',
                'description' => 'Elegant women\'s high heels for special occasions and formal events.',
                'image' => 'images/subcategories/womens-high-heels.jpg',
                'meta_title' => 'Women\'s High Heels | Elegant Footwear',
                'meta_description' => 'Elevate your style with our collection of women\'s high heels.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'womens-shoes',
                'name' => 'Flats',
                'slug' => 'womens-flats',
                'description' => 'Comfortable women\'s flats for everyday elegance.',
                'image' => 'images/subcategories/womens-flats.jpg',
                'meta_title' => 'Women\'s Flats | Comfortable Elegance',
                'meta_description' => 'Discover comfortable women\'s flats perfect for everyday wear.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'womens-shoes',
                'name' => 'Sneakers',
                'slug' => 'womens-sneakers',
                'description' => 'Stylish women\'s sneakers for casual and athletic activities.',
                'image' => 'images/subcategories/womens-sneakers.jpg',
                'meta_title' => 'Women\'s Sneakers | Casual & Athletic',
                'meta_description' => 'Shop stylish women\'s sneakers for casual and athletic wear.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'category_slug' => 'womens-shoes',
                'name' => 'Boots',
                'slug' => 'womens-boots',
                'description' => 'Fashionable women\'s boots for all seasons and occasions.',
                'image' => 'images/subcategories/womens-boots.jpg',
                'meta_title' => 'Women\'s Boots | Fashionable Footwear',
                'meta_description' => 'Complete your look with our fashionable women\'s boots collection.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'category_slug' => 'womens-shoes',
                'name' => 'Sandals',
                'slug' => 'womens-sandals',
                'description' => 'Trendy women\'s sandals for summer and beach wear.',
                'image' => 'images/subcategories/womens-sandals.jpg',
                'meta_title' => 'Women\'s Sandals | Summer Style',
                'meta_description' => 'Stay stylish in summer with our women\'s sandals collection.',
                'is_active' => true,
                'sort_order' => 5,
            ],

            // Kids' Shoes Subcategories
            [
                'category_slug' => 'kids-shoes',
                'name' => 'School Shoes',
                'slug' => 'kids-school-shoes',
                'description' => 'Durable and comfortable school shoes for children.',
                'image' => 'images/subcategories/kids-school-shoes.jpg',
                'meta_title' => 'Kids\' School Shoes | Durable & Comfortable',
                'meta_description' => 'Find durable and comfortable school shoes for your children.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'kids-shoes',
                'name' => 'Sneakers',
                'slug' => 'kids-sneakers',
                'description' => 'Fun and comfortable sneakers for active kids.',
                'image' => 'images/subcategories/kids-sneakers.jpg',
                'meta_title' => 'Kids\' Sneakers | Fun & Comfortable',
                'meta_description' => 'Shop fun and comfortable sneakers for active children.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'kids-shoes',
                'name' => 'Boots',
                'slug' => 'kids-boots',
                'description' => 'Sturdy boots for kids\' outdoor adventures.',
                'image' => 'images/subcategories/kids-boots.jpg',
                'meta_title' => 'Kids\' Boots | Outdoor Adventures',
                'meta_description' => 'Gear up your kids with sturdy boots for outdoor activities.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'category_slug' => 'kids-shoes',
                'name' => 'Sandals',
                'slug' => 'kids-sandals',
                'description' => 'Comfortable sandals for kids\' summer activities.',
                'image' => 'images/subcategories/kids-sandals.jpg',
                'meta_title' => 'Kids\' Sandals | Summer Comfort',
                'meta_description' => 'Keep your kids comfortable with our sandals collection.',
                'is_active' => true,
                'sort_order' => 4,
            ],

            // Sports & Athletic Subcategories
            [
                'category_slug' => 'sports-athletic',
                'name' => 'Running Shoes',
                'slug' => 'running-shoes',
                'description' => 'Performance running shoes for all distances and terrains.',
                'image' => 'images/subcategories/running-shoes.jpg',
                'meta_title' => 'Running Shoes | Performance Footwear',
                'meta_description' => 'Find the perfect running shoes for your running goals and preferences.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'sports-athletic',
                'name' => 'Basketball Shoes',
                'slug' => 'basketball-shoes',
                'description' => 'High-performance basketball shoes for court dominance.',
                'image' => 'images/subcategories/basketball-shoes.jpg',
                'meta_title' => 'Basketball Shoes | Court Performance',
                'meta_description' => 'Dominate the court with our high-performance basketball shoes.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'sports-athletic',
                'name' => 'Training Shoes',
                'slug' => 'training-shoes',
                'description' => 'Versatile training shoes for gym and cross-training.',
                'image' => 'images/subcategories/training-shoes.jpg',
                'meta_title' => 'Training Shoes | Gym & Cross-Training',
                'meta_description' => 'Get versatile training shoes for all your gym and cross-training needs.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'category_slug' => 'sports-athletic',
                'name' => 'Tennis Shoes',
                'slug' => 'tennis-shoes',
                'description' => 'Professional tennis shoes for court performance.',
                'image' => 'images/subcategories/tennis-shoes.jpg',
                'meta_title' => 'Tennis Shoes | Court Performance',
                'meta_description' => 'Improve your tennis game with our professional tennis shoes.',
                'is_active' => true,
                'sort_order' => 4,
            ],

            // Casual Shoes Subcategories
            [
                'category_slug' => 'casual-shoes',
                'name' => 'Loafers',
                'slug' => 'loafers',
                'description' => 'Classic loafers for sophisticated casual style.',
                'image' => 'images/subcategories/loafers.jpg',
                'meta_title' => 'Loafers | Sophisticated Style',
                'meta_description' => 'Add sophistication to your casual look with our loafers collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'casual-shoes',
                'name' => 'Slip-Ons',
                'slug' => 'slip-ons',
                'description' => 'Easy-to-wear slip-on shoes for ultimate comfort.',
                'image' => 'images/subcategories/slip-ons.jpg',
                'meta_title' => 'Slip-On Shoes | Easy Comfort',
                'meta_description' => 'Experience ultimate comfort with our easy-to-wear slip-on shoes.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'casual-shoes',
                'name' => 'Canvas Shoes',
                'slug' => 'canvas-shoes',
                'description' => 'Classic canvas shoes for timeless casual style.',
                'image' => 'images/subcategories/canvas-shoes.jpg',
                'meta_title' => 'Canvas Shoes | Timeless Style',
                'meta_description' => 'Get the classic look with our timeless canvas shoes collection.',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Formal Shoes Subcategories
            [
                'category_slug' => 'formal-shoes',
                'name' => 'Oxfords',
                'slug' => 'oxfords',
                'description' => 'Classic oxford shoes for formal occasions.',
                'image' => 'images/subcategories/oxfords.jpg',
                'meta_title' => 'Oxford Shoes | Classic Formal',
                'meta_description' => 'Make a statement with our classic oxford shoes collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'formal-shoes',
                'name' => 'Derby Shoes',
                'slug' => 'derby-shoes',
                'description' => 'Versatile derby shoes for business and formal wear.',
                'image' => 'images/subcategories/derby-shoes.jpg',
                'meta_title' => 'Derby Shoes | Business Formal',
                'meta_description' => 'Choose versatile derby shoes for business and formal occasions.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Boots & Ankle Boots Subcategories
            [
                'category_slug' => 'boots-ankle-boots',
                'name' => 'Combat Boots',
                'slug' => 'combat-boots',
                'description' => 'Rugged combat boots for urban and outdoor style.',
                'image' => 'images/subcategories/combat-boots.jpg',
                'meta_title' => 'Combat Boots | Rugged Style',
                'meta_description' => 'Add edge to your style with our rugged combat boots collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'boots-ankle-boots',
                'name' => 'Chelsea Boots',
                'slug' => 'chelsea-boots',
                'description' => 'Timeless chelsea boots for versatile styling.',
                'image' => 'images/subcategories/chelsea-boots.jpg',
                'meta_title' => 'Chelsea Boots | Timeless Style',
                'meta_description' => 'Invest in timeless style with our chelsea boots collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'boots-ankle-boots',
                'name' => 'Ankle Boots',
                'slug' => 'ankle-boots',
                'description' => 'Stylish ankle boots for fashion-forward looks.',
                'image' => 'images/subcategories/ankle-boots.jpg',
                'meta_title' => 'Ankle Boots | Fashion Forward',
                'meta_description' => 'Stay fashion-forward with our stylish ankle boots collection.',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Sandals & Flip Flops Subcategories
            [
                'category_slug' => 'sandals-flip-flops',
                'name' => 'Flip Flops',
                'slug' => 'flip-flops',
                'description' => 'Comfortable flip flops for beach and casual wear.',
                'image' => 'images/subcategories/flip-flops.jpg',
                'meta_title' => 'Flip Flops | Beach Comfort',
                'meta_description' => 'Stay comfortable at the beach with our flip flops collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'sandals-flip-flops',
                'name' => 'Slides',
                'slug' => 'slides',
                'description' => 'Easy-to-wear slides for ultimate comfort.',
                'image' => 'images/subcategories/slides.jpg',
                'meta_title' => 'Slides | Ultimate Comfort',
                'meta_description' => 'Experience ultimate comfort with our slides collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($subcategories as $subcategoryData) {
            $category = Category::where('slug', $subcategoryData['category_slug'])->first();

            if ($category) {
                $subcategory = [
                    'category_id' => $category->id,
                    'name' => $subcategoryData['name'],
                    'slug' => $subcategoryData['slug'],
                    'description' => $subcategoryData['description'],
                    'image' => $subcategoryData['image'],
                    'meta_title' => $subcategoryData['meta_title'],
                    'meta_description' => $subcategoryData['meta_description'],
                    'is_active' => $subcategoryData['is_active'],
                    'sort_order' => $subcategoryData['sort_order'],
                ];

                Subcategory::updateOrCreate(
                    ['slug' => $subcategoryData['slug']],
                    $subcategory
                );
            }
        }
    }
}
