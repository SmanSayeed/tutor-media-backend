<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $this->call([
            BrandSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            ChildCategorySeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
            UserSeeder::class,
            ProductImageSeeder::class,
            BannerSeeder::class,
            CouponSeeder::class,
            ZoneAreaSeeder::class,
            AdvancePaymentSettingSeeder::class,
        ]);

    }
}
