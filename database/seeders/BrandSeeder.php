<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Nike', 'slug' => 'nike', 'is_active' => true],
            ['name' => 'Adidas', 'slug' => 'adidas', 'is_active' => true],
            ['name' => 'Puma', 'slug' => 'puma', 'is_active' => true],
            ['name' => 'Reebok', 'slug' => 'reebok', 'is_active' => true],
            ['name' => 'New Balance', 'slug' => 'new-balance', 'is_active' => true],
            ['name' => 'Converse', 'slug' => 'converse', 'is_active' => true],
            ['name' => 'Vans', 'slug' => 'vans', 'is_active' => true],
            ['name' => 'Dr. Martens', 'slug' => 'dr-martens', 'is_active' => true],
            ['name' => 'Timberland', 'slug' => 'timberland', 'is_active' => true],
            ['name' => 'Clarks', 'slug' => 'clarks', 'is_active' => true],
            ['name' => 'Skechers', 'slug' => 'skechers', 'is_active' => true],
            ['name' => 'Under Armour', 'slug' => 'under-armour', 'is_active' => true],
            ['name' => 'ASICS', 'slug' => 'asics', 'is_active' => true],
            ['name' => 'Fila', 'slug' => 'fila', 'is_active' => true],
            ['name' => 'Salomon', 'slug' => 'salomon', 'is_active' => true],
            ['name' => 'Merrell', 'slug' => 'merrell', 'is_active' => true],
            ['name' => 'Columbia', 'slug' => 'columbia', 'is_active' => true],
            ['name' => 'The North Face', 'slug' => 'the-north-face', 'is_active' => true],
            ['name' => 'Crocs', 'slug' => 'crocs', 'is_active' => true],
            ['name' => 'Birkenstock', 'slug' => 'birkenstock', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}