<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('video URL can be saved to product', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'Test description',
        'price' => 100.00,
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'is_active' => true,
    ]);

    expect($product->video_url)->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
});

test('video URL is displayed on product page', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'Test description',
        'price' => 100.00,
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'is_active' => true,
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertSee('youtube.com/embed/dQw4w9WgXcQ', false);
});

test('product page does not show video when video_url is null', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'Test description',
        'price' => 100.00,
        'video_url' => null,
        'is_active' => true,
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertDontSee('youtube.com/embed', false);
});

test('video URL validation accepts valid YouTube URLs', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    // Test different YouTube URL formats
    $validUrls = [
        'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'https://youtu.be/dQw4w9WgXcQ',
        'https://youtube.com/embed/dQw4w9WgXcQ',
    ];

    foreach ($validUrls as $url) {
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product ' . rand(),
            'slug' => 'test-product-' . rand(),
            'description' => 'Test description',
            'price' => 100.00,
            'video_url' => $url,
            'is_active' => true,
        ]);

        expect($product->video_url)->toBe($url);
    }
});
