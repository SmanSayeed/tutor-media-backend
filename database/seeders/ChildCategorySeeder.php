<?php

namespace Database\Seeders;

use App\Models\ChildCategory;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChildCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $childCategories = [
            // Men's Sneakers Child Categories
            [
                'subcategory_slug' => 'mens-sneakers',
                'name' => 'Lifestyle Sneakers',
                'slug' => 'mens-lifestyle-sneakers',
                'description' => 'Casual lifestyle sneakers for everyday wear.',
                'image' => 'images/childcategories/mens-lifestyle-sneakers.jpg',
                'meta_title' => 'Men\'s Lifestyle Sneakers | Casual Comfort',
                'meta_description' => 'Discover casual lifestyle sneakers perfect for everyday comfort and style.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'mens-sneakers',
                'name' => 'Athletic Sneakers',
                'slug' => 'mens-athletic-sneakers',
                'description' => 'Performance athletic sneakers for sports and training.',
                'image' => 'images/childcategories/mens-athletic-sneakers.jpg',
                'meta_title' => 'Men\'s Athletic Sneakers | Performance Wear',
                'meta_description' => 'Gear up with performance athletic sneakers for sports and training.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'subcategory_slug' => 'mens-sneakers',
                'name' => 'High-Top Sneakers',
                'slug' => 'mens-high-top-sneakers',
                'description' => 'Stylish high-top sneakers with ankle support.',
                'image' => 'images/childcategories/mens-high-top-sneakers.jpg',
                'meta_title' => 'Men\'s High-Top Sneakers | Ankle Support',
                'meta_description' => 'Get stylish high-top sneakers with excellent ankle support and protection.',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Women's High Heels Child Categories
            [
                'subcategory_slug' => 'womens-high-heels',
                'name' => 'Stiletto Heels',
                'slug' => 'womens-stiletto-heels',
                'description' => 'Elegant stiletto heels for formal occasions.',
                'image' => 'images/childcategories/womens-stiletto-heels.jpg',
                'meta_title' => 'Women\'s Stiletto Heels | Elegant Formal',
                'meta_description' => 'Add elegance to your formal look with our stiletto heels collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'womens-high-heels',
                'name' => 'Block Heels',
                'slug' => 'womens-block-heels',
                'description' => 'Comfortable block heels for all-day wear.',
                'image' => 'images/childcategories/womens-block-heels.jpg',
                'meta_title' => 'Women\'s Block Heels | Comfortable Height',
                'meta_description' => 'Stay comfortable in style with our block heels collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'subcategory_slug' => 'womens-high-heels',
                'name' => 'Kitten Heels',
                'slug' => 'womens-kitten-heels',
                'description' => 'Petite kitten heels for subtle elegance.',
                'image' => 'images/childcategories/womens-kitten-heels.jpg',
                'meta_title' => 'Women\'s Kitten Heels | Subtle Elegance',
                'meta_description' => 'Add subtle elegance with our kitten heels collection.',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Kids School Shoes Child Categories
            [
                'subcategory_slug' => 'kids-school-shoes',
                'name' => 'Mary Jane Shoes',
                'slug' => 'kids-mary-jane-shoes',
                'description' => 'Classic Mary Jane shoes for school uniforms.',
                'image' => 'images/childcategories/kids-mary-jane-shoes.jpg',
                'meta_title' => 'Kids\' Mary Jane Shoes | School Uniform',
                'meta_description' => 'Find classic Mary Jane shoes perfect for school uniforms.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'kids-school-shoes',
                'name' => 'Velcro Shoes',
                'slug' => 'kids-velcro-shoes',
                'description' => 'Easy-to-wear velcro shoes for young children.',
                'image' => 'images/childcategories/kids-velcro-shoes.jpg',
                'meta_title' => 'Kids\' Velcro Shoes | Easy Wear',
                'meta_description' => 'Make getting ready easier with our velcro shoes for kids.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Running Shoes Child Categories
            [
                'subcategory_slug' => 'running-shoes',
                'name' => 'Road Running',
                'slug' => 'road-running-shoes',
                'description' => 'Running shoes optimized for road and pavement running.',
                'image' => 'images/childcategories/road-running-shoes.jpg',
                'meta_title' => 'Road Running Shoes | Pavement Performance',
                'meta_description' => 'Get optimal performance on roads and pavements with our road running shoes.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'running-shoes',
                'name' => 'Trail Running',
                'slug' => 'trail-running-shoes',
                'description' => 'Durable trail running shoes for off-road adventures.',
                'image' => 'images/childcategories/trail-running-shoes.jpg',
                'meta_title' => 'Trail Running Shoes | Off-Road Performance',
                'meta_description' => 'Conquer trails with our durable trail running shoes collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Basketball Shoes Child Categories
            [
                'subcategory_slug' => 'basketball-shoes',
                'name' => 'High-Top Basketball',
                'slug' => 'high-top-basketball-shoes',
                'description' => 'High-top basketball shoes for maximum ankle support.',
                'image' => 'images/childcategories/high-top-basketball-shoes.jpg',
                'meta_title' => 'High-Top Basketball Shoes | Maximum Support',
                'meta_description' => 'Get maximum ankle support with our high-top basketball shoes.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'basketball-shoes',
                'name' => 'Low-Top Basketball',
                'slug' => 'low-top-basketball-shoes',
                'description' => 'Low-top basketball shoes for speed and agility.',
                'image' => 'images/childcategories/low-top-basketball-shoes.jpg',
                'meta_title' => 'Low-Top Basketball Shoes | Speed & Agility',
                'meta_description' => 'Enhance your speed and agility with our low-top basketball shoes.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Boots Child Categories
            [
                'subcategory_slug' => 'mens-boots',
                'name' => 'Work Boots',
                'slug' => 'mens-work-boots',
                'description' => 'Durable work boots for construction and industrial work.',
                'image' => 'images/childcategories/mens-work-boots.jpg',
                'meta_title' => 'Men\'s Work Boots | Industrial Durability',
                'meta_description' => 'Get durable work boots designed for construction and industrial work.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'mens-boots',
                'name' => 'Hiking Boots',
                'slug' => 'mens-hiking-boots',
                'description' => 'Comfortable hiking boots for outdoor adventures.',
                'image' => 'images/childcategories/mens-hiking-boots.jpg',
                'meta_title' => 'Men\'s Hiking Boots | Outdoor Adventures',
                'meta_description' => 'Gear up for outdoor adventures with our comfortable hiking boots.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Women's Boots Child Categories
            [
                'subcategory_slug' => 'womens-boots',
                'name' => 'Over-the-Knee Boots',
                'slug' => 'womens-over-the-knee-boots',
                'description' => 'Fashionable over-the-knee boots for statement looks.',
                'image' => 'images/childcategories/womens-over-the-knee-boots.jpg',
                'meta_title' => 'Women\'s Over-the-Knee Boots | Statement Style',
                'meta_description' => 'Make a statement with our fashionable over-the-knee boots collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'womens-boots',
                'name' => 'Knee-High Boots',
                'slug' => 'womens-knee-high-boots',
                'description' => 'Versatile knee-high boots for various occasions.',
                'image' => 'images/childcategories/womens-knee-high-boots.jpg',
                'meta_title' => 'Women\'s Knee-High Boots | Versatile Style',
                'meta_description' => 'Stay versatile with our knee-high boots collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Combat Boots Child Categories
            [
                'subcategory_slug' => 'combat-boots',
                'name' => 'Leather Combat Boots',
                'slug' => 'leather-combat-boots',
                'description' => 'Premium leather combat boots for durability and style.',
                'image' => 'images/childcategories/leather-combat-boots.jpg',
                'meta_title' => 'Leather Combat Boots | Premium Durability',
                'meta_description' => 'Invest in premium leather combat boots that combine durability and style.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'combat-boots',
                'name' => 'Canvas Combat Boots',
                'slug' => 'canvas-combat-boots',
                'description' => 'Lightweight canvas combat boots for casual wear.',
                'image' => 'images/childcategories/canvas-combat-boots.jpg',
                'meta_title' => 'Canvas Combat Boots | Lightweight Style',
                'meta_description' => 'Get lightweight style with our canvas combat boots collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Formal Shoes Child Categories
            [
                'subcategory_slug' => 'oxfords',
                'name' => 'Plain Toe Oxfords',
                'slug' => 'plain-toe-oxfords',
                'description' => 'Classic plain toe oxfords for formal occasions.',
                'image' => 'images/childcategories/plain-toe-oxfords.jpg',
                'meta_title' => 'Plain Toe Oxfords | Classic Formal',
                'meta_description' => 'Choose classic plain toe oxfords for your formal occasions.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'oxfords',
                'name' => 'Cap Toe Oxfords',
                'slug' => 'cap-toe-oxfords',
                'description' => 'Sophisticated cap toe oxfords for business wear.',
                'image' => 'images/childcategories/cap-toe-oxfords.jpg',
                'meta_title' => 'Cap Toe Oxfords | Business Sophistication',
                'meta_description' => 'Add sophistication to your business look with cap toe oxfords.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Derby Shoes Child Categories
            [
                'subcategory_slug' => 'derby-shoes',
                'name' => 'Plain Derby Shoes',
                'slug' => 'plain-derby-shoes',
                'description' => 'Versatile plain derby shoes for business casual.',
                'image' => 'images/childcategories/plain-derby-shoes.jpg',
                'meta_title' => 'Plain Derby Shoes | Business Casual',
                'meta_description' => 'Get versatile plain derby shoes perfect for business casual wear.',
                'is_active' => true,
                'sort_order' => 1,
            ],

            // Flip Flops Child Categories
            [
                'subcategory_slug' => 'flip-flops',
                'name' => 'Beach Flip Flops',
                'slug' => 'beach-flip-flops',
                'description' => 'Comfortable beach flip flops for summer relaxation.',
                'image' => 'images/childcategories/beach-flip-flops.jpg',
                'meta_title' => 'Beach Flip Flops | Summer Relaxation',
                'meta_description' => 'Relax in style with our comfortable beach flip flops collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'flip-flops',
                'name' => 'Casual Flip Flops',
                'slug' => 'casual-flip-flops',
                'description' => 'Everyday casual flip flops for comfort.',
                'image' => 'images/childcategories/casual-flip-flops.jpg',
                'meta_title' => 'Casual Flip Flops | Everyday Comfort',
                'meta_description' => 'Experience everyday comfort with our casual flip flops collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Slides Child Categories
            [
                'subcategory_slug' => 'slides',
                'name' => 'Pool Slides',
                'slug' => 'pool-slides',
                'description' => 'Water-resistant pool slides for aquatic activities.',
                'image' => 'images/childcategories/pool-slides.jpg',
                'meta_title' => 'Pool Slides | Water-Resistant Comfort',
                'meta_description' => 'Stay comfortable around water with our pool slides collection.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'slides',
                'name' => 'Shower Slides',
                'slug' => 'shower-slides',
                'description' => 'Quick-dry shower slides for bathroom use.',
                'image' => 'images/childcategories/shower-slides.jpg',
                'meta_title' => 'Shower Slides | Quick-Dry Comfort',
                'meta_description' => 'Get quick-dry comfort with our shower slides collection.',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($childCategories as $childCategoryData) {
            $subcategory = Subcategory::where('slug', $childCategoryData['subcategory_slug'])->first();

            if ($subcategory) {
                $childCategory = [
                    'subcategory_id' => $subcategory->id,
                    'name' => $childCategoryData['name'],
                    'slug' => $childCategoryData['slug'],
                    'description' => $childCategoryData['description'],
                    'image' => $childCategoryData['image'],
                    'meta_title' => $childCategoryData['meta_title'],
                    'meta_description' => $childCategoryData['meta_description'],
                    'is_active' => $childCategoryData['is_active'],
                    'sort_order' => $childCategoryData['sort_order'],
                ];

                ChildCategory::updateOrCreate(
                    ['slug' => $childCategoryData['slug']],
                    $childCategory
                );
            }
        }
    }
}
