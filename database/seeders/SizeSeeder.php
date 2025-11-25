<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            // Men's sizes (US)
            ['name' => '39'],       
            ['name' => '40'],       
            ['name' => '41'],       
            ['name' => '42'],       
            ['name' => '43'],       
            ['name' => '44'],       
            ['name' => '45'],       
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(['name' => $size['name']], $size);
        }
    }
}
