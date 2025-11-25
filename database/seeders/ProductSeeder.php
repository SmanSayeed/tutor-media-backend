<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = Subcategory::with('category')
            ->where('is_active', true)
            ->get();

        if ($subcategories->isEmpty()) {
            $this->command?->warn('No active subcategories found. Skipping product seeding.');
            return;
        }

        $brandIds = Brand::where('is_active', true)->pluck('id');
        $colorIds = Color::pluck('id');
    $imageCatalog = $this->imageCatalog();
        $defaultImages = $imageCatalog['default'];
        unset($imageCatalog['default']);

        $materials = ['Full-grain leather', 'Engineered mesh', 'Knit textile', 'Suede', 'Synthetic leather', 'Canvas'];
        $soles = ['Rubber outsole', 'EVA foam', 'Vibram grip', 'Carbon rubber', 'Thermo rubber'];
        $closures = ['Traditional lacing', 'Quick-pull laces', 'Elastic strap', 'Hook-and-loop', 'Slip-on'];

        Product::withoutSyncingToSearch(function () use (
            $subcategories,
            $brandIds,
            $colorIds,
            $imageCatalog,
            $defaultImages,
            $materials,
            $soles,
            $closures
        ) {
            foreach ($subcategories as $subcategory) {
                for ($i = 1; $i <= 6; $i++) {
                    $descriptor = Arr::random(['Elite', 'Pro', 'Essential', 'Prime', 'Fusion', 'Velocity', 'Heritage', 'Quantum']);
                    $series = Arr::random(['Series', 'Collection', 'Line', 'Edition']);
                    $suffix = Str::upper(Str::random(3));

                    $name = trim(sprintf('%s %s %s %s', $subcategory->name, $descriptor, $series, $suffix));
                    $slug = Str::slug($subcategory->slug . '-' . $descriptor . '-' . $i);

                    $price = fake()->randomFloat(2, 45, 320);
                    $salePrice = fake()->boolean(45)
                        ? max(20, round($price - fake()->randomFloat(2, 5, 40), 2))
                        : null;

                    $imageUrl = $this->resolveImageUrl(
                        $imageCatalog,
                        $defaultImages,
                        $subcategory,
                        $name,
                        $i
                    );

                    $productData = [
                        'category_id' => $subcategory->category_id,
                        'subcategory_id' => $subcategory->id,
                        'brand_id' => $brandIds->isNotEmpty() ? $brandIds->random() : null,
                        'color_id' => $colorIds->isNotEmpty() ? $colorIds->random() : null,
                        'name' => $name,
                        'slug' => $slug,
                        'description' => fake()->paragraphs(2, true),
                        'short_description' => fake()->sentence(),
                        'sku' => strtoupper(str_pad((string) $subcategory->id, 3, '0', STR_PAD_LEFT)) . '-' . $i . Str::upper(Str::random(3)),
                        'main_image' => $imageUrl,
                        'price' => $price,
                        'sale_price' => $salePrice,
                        'cost_price' => round($price * 0.55, 2),
                        'features' => fake()->sentences(4),
                        'specifications' => [
                            'Upper Material' => Arr::random($materials),
                            'Sole Construction' => Arr::random($soles),
                            'Closure Type' => Arr::random($closures),
                            'Weight' => fake()->numberBetween(240, 520) . 'g (per shoe)',
                            'Model Code' => strtoupper(Str::random(6)),
                        ],
                        'meta_title' => $name . ' | ' . $subcategory->name,
                        'meta_description' => fake()->sentence(12),
                        'is_active' => true,
                        'is_featured' => fake()->boolean(20),
                        'view_count' => fake()->numberBetween(50, 1200),
                        'sales_count' => fake()->numberBetween(5, 180),
                        'sale_start_date' => $salePrice ? now()->subDays(fake()->numberBetween(3, 30)) : null,
                        'sale_end_date' => $salePrice ? now()->addDays(fake()->numberBetween(10, 45)) : null,
                    ];

                    Product::updateOrCreate(
                        ['slug' => $slug],
                        $productData
                    );
                }
            }
        });

        $this->command?->info('Products seeded: 6 per subcategory.');
    }

    /**
     * Resolve an image URL for the given subcategory context.
     */
    private function resolveImageUrl(array $imageCatalog, array $defaultImages, Subcategory $subcategory, string $name, int $sequence): string
    {
        $context = Str::lower($subcategory->slug . ' ' . $subcategory->name . ' ' . $name);

        foreach ($imageCatalog as $keyword => $images) {
            if (Str::contains($context, $keyword) && ! empty($images)) {
                return $images[$sequence % count($images)];
            }
        }

        return $defaultImages[$sequence % count($defaultImages)];
    }

    /**
     * Predefined catalog of shoe imagery grouped by keyword.
     */
    private function imageCatalog(): array
    {
        return [
            'sneaker' => $this->productImagePaths([
                'shoe-1.jpg',
                'shoe-2.jpg',
                'shoe-3.jpg',
                'shoe-4.jpg',
            ]),
            'running' => $this->productImagePaths([
                'shoe-5.jpg',
                'shoe-6.jpg',
            ]),
            'basketball' => $this->productImagePaths([
                'shoe-7.jpg',
                'shoe-8.jpg',
            ]),
            'training' => $this->productImagePaths([
                'shoe-9.jpg',
                'shoe-10.jpg',
            ]),
            'tennis' => $this->productImagePaths([
                'shoe-11.jpg',
                'shoe-12.jpg',
            ]),
            'boot' => $this->productImagePaths([
                'shoe-17.jpg',
                'shoe-18.jpg',
            ]),
            'hiker' => $this->productImagePaths([
                'shoe-17.jpg',
                'shoe-18.jpg',
            ]),
            'heel' => $this->productImagePaths([
                'shoe-5.jpg',
                'shoe-6.jpg',
            ]),
            'flat' => $this->productImagePaths([
                'shoe-9.jpg',
                'shoe-10.jpg',
            ]),
            'loafer' => $this->productImagePaths([
                'shoe-7.jpg',
                'shoe-8.jpg',
            ]),
            'slip' => $this->productImagePaths([
                'shoe-9.jpg',
                'shoe-10.jpg',
            ]),
            'canvas' => $this->productImagePaths([
                'shoe-1.jpg',
                'shoe-2.jpg',
            ]),
            'oxford' => $this->productImagePaths([
                'shoe-7.jpg',
                'shoe-8.jpg',
            ]),
            'derby' => $this->productImagePaths([
                'shoe-7.jpg',
                'shoe-8.jpg',
            ]),
            'combat' => $this->productImagePaths([
                'shoe-17.jpg',
                'shoe-18.jpg',
            ]),
            'chelsea' => $this->productImagePaths([
                'shoe-17.jpg',
                'shoe-18.jpg',
            ]),
            'ankle' => $this->productImagePaths([
                'shoe-17.jpg',
                'shoe-18.jpg',
            ]),
            'sandal' => $this->productImagePaths([
                'shoe-9.jpg',
                'shoe-10.jpg',
            ]),
            'flip' => $this->productImagePaths([
                'shoe-9.jpg',
                'shoe-10.jpg',
            ]),
            'slide' => $this->productImagePaths([
                'shoe-9.jpg',
                'shoe-10.jpg',
            ]),
            'school' => $this->productImagePaths([
                'shoe-11.jpg',
                'shoe-12.jpg',
            ]),
            'kid' => $this->productImagePaths([
                'shoe-5.jpg',
                'shoe-6.jpg',
            ]),
            'default' => $this->productImagePaths([
                'shoe-1.jpg',
                'shoe-2.jpg',
                'shoe-3.jpg',
                'shoe-4.jpg',
                'shoe-5.jpg',
                'shoe-6.jpg',
                'shoe-7.jpg',
                'shoe-8.jpg',
                'shoe-9.jpg',
                'shoe-10.jpg',
                'shoe-11.jpg',
                'shoe-12.jpg',
                'shoe-17.jpg',
                'shoe-18.jpg',
            ]),
        ];
    }

    /**
     * Prefix filenames with the public product image directory.
     */
    private function productImagePaths(array $filenames): array
    {
        return array_map(static fn (string $filename): string => 'images/products/' . ltrim($filename, '/'), $filenames);
    }
}
