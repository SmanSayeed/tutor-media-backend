<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a product', function () {
    $category = Category::create(['name' => 'Test Category']);
    $brand = Brand::create(['name' => 'Test Brand']);

    $product = Product::create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'name' => 'Test Shoe',
        'description' => 'A great test shoe',
        'price' => 99.99,
        'stock_quantity' => 10,
    ]);

    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->name)->toBe('Test Shoe')
        ->and($product->price)->toBe('99.99')
        ->and($product->stock_quantity)->toBe(10);
});

test('product slug is auto-generated', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Nike Air Max',
        'description' => 'Test',
        'price' => 150.00,
    ]);

    expect($product->slug)->toBe('nike-air-max');
});

test('product sku is auto-generated', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Test',
        'price' => 100.00,
    ]);

    expect($product->sku)->toStartWith('SKU-')
        ->and(strlen($product->sku))->toBe(12);
});

test('product can check if on sale', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Test',
        'price' => 100.00,
        'sale_price' => 80.00,
        'sale_start_date' => now()->subDay(),
        'sale_end_date' => now()->addDay(),
    ]);

    expect($product->isOnSale())->toBeTrue();
});

test('product can check if in stock', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Test',
        'price' => 100.00,
        'stock_quantity' => 5,
        'track_inventory' => true,
    ]);

    expect($product->isInStock())->toBeTrue();
});

test('product can calculate current price', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Test',
        'price' => 100.00,
        'sale_price' => 80.00,
        'sale_start_date' => now()->subDay(),
        'sale_end_date' => now()->addDay(),
    ]);

    expect($product->current_price)->toBe('80.00');
});

test('product can calculate discount percentage', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Test',
        'price' => 100.00,
        'sale_price' => 80.00,
        'sale_start_date' => now()->subDay(),
        'sale_end_date' => now()->addDay(),
    ]);

    expect($product->discount_percentage)->toBe(20);
});

test('product has category relationship', function () {
    $category = Category::create(['name' => 'Test Category']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Test',
        'price' => 100.00,
    ]);

    expect($product->category)->toBeInstanceOf(Category::class)
        ->and($product->category->name)->toBe('Test Category');
});


