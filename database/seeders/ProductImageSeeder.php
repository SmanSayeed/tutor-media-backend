<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        // Default image path if main_image is not set
        $defaultImage = '/images/products/default-shoe.jpg';

        foreach ($products as $product) {
            $mainImage = $product->main_image ?: $defaultImage;
            
            // Create multiple images for each product
            $images = [
                [
                    'image_path' => $mainImage,
                    'alt_text' => $product->name . ' - Main View',
                    'is_primary' => true,
                    'sort_order' => 0,
                ],
                [
                    'image_path' => str_contains($mainImage, '?') ? 
                        str_replace('w=800&h=600', 'w=800&h=600&crop=center', $mainImage) : 
                        $mainImage . '?w=800&h=600&crop=center',
                    'alt_text' => $product->name . ' - Side View',
                    'is_primary' => false,
                    'sort_order' => 1,
                ],
                [
                    'image_path' => str_contains($mainImage, '?') ?
                        str_replace('w=800&h=600', 'w=800&h=600&crop=top', $mainImage) :
                        $mainImage . '?w=800&h=600&crop=top',
                    'alt_text' => $product->name . ' - Top View',
                    'is_primary' => false,
                    'sort_order' => 2,
                ],
                [
                    'image_path' => str_contains($mainImage, '?') ?
                        str_replace('w=800&h=600', 'w=800&h=600&crop=bottom', $mainImage) :
                        $mainImage . '?w=800&h=600&crop=bottom',
                    'alt_text' => $product->name . ' - Detail View',
                    'is_primary' => false,
                    'sort_order' => 3,
                ],
            ];

            foreach ($images as $imageData) {
                // Skip if image_path is empty
                if (empty($imageData['image_path'])) {
                    continue;
                }
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageData['image_path'],
                    'alt_text' => $imageData['alt_text'],
                    'is_primary' => $imageData['is_primary'],
                    'sort_order' => $imageData['sort_order'],
                ]);
            }
        }

        $this->command->info('Product images seeded successfully!');
    }
}
