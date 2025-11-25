<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'code' => 'BLACK', 'hex_code' => '#000000'],
            ['name' => 'White', 'code' => 'WHITE', 'hex_code' => '#FFFFFF'],
            ['name' => 'Navy Blue', 'code' => 'NAVY', 'hex_code' => '#000080'],
            ['name' => 'Brown', 'code' => 'BROWN', 'hex_code' => '#8B4513'],
            ['name' => 'Gray', 'code' => 'GRAY', 'hex_code' => '#808080'],
            ['name' => 'Light Gray', 'code' => 'LIGHT_GRAY', 'hex_code' => '#D3D3D3'],
            ['name' => 'Dark Gray', 'code' => 'DARK_GRAY', 'hex_code' => '#A9A9A9'],
            ['name' => 'Red', 'code' => 'RED', 'hex_code' => '#DC143C'],
            ['name' => 'Pink', 'code' => 'PINK', 'hex_code' => '#FFC0CB'],
            ['name' => 'Beige', 'code' => 'BEIGE', 'hex_code' => '#F5F5DC'],
            ['name' => 'Tan', 'code' => 'TAN', 'hex_code' => '#D2B48C'],
            ['name' => 'Burgundy', 'code' => 'BURGUNDY', 'hex_code' => '#800020'],
            ['name' => 'Forest Green', 'code' => 'FOREST_GREEN', 'hex_code' => '#228B22'],
            ['name' => 'Royal Blue', 'code' => 'ROYAL_BLUE', 'hex_code' => '#4169E1'],
            ['name' => 'Purple', 'code' => 'PURPLE', 'hex_code' => '#800080'],
        ];

        foreach ($colors as $color) {
            Color::updateOrCreate(['code' => $color['code']], $color);
        }
    }
}
