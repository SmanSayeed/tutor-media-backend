<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{

    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product->variants()->create([
                'stock_quantity' => rand(5, 50),
                'size_id' => rand(1, 7),
                'is_active' => true,               
            ]);
        }
        foreach ($products as $product) {
            $product->variants()->create([
                'stock_quantity' => rand(5, 50),
                'size_id' => rand(1, 7),
                'is_active' => true,               
            ]);
        }
        foreach ($products as $product) {
            $product->variants()->create([
                'stock_quantity' => rand(5, 50),
                'size_id' => rand(1, 7),
                'is_active' => true,               
            ]);
        }

    }


}
