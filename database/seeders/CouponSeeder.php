<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the Coupon model exists before using it
        if (!class_exists(Coupon::class)) {
            return;
        }

        Coupon::factory()->create([
            'code' => 'SAVE10',
            'type' => 'fixed',
            'value' => 10,
        ]);

        Coupon::factory()->create([
            'code' => 'PERCENT20',
            'type' => 'percent',
            'value' => 20,
        ]);

        Coupon::factory(5)->create();
    }
}
