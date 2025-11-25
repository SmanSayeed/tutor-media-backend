<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('homepage loads successfully', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('SSB Leather')
             ->assertSee('Welcome to Our Store');
});

test('homepage displays hero slider with banners', function () {
    Banner::create([
        'title' => 'Test Banner',
        'subtitle' => 'Test Subtitle',
        'image_url' => 'test-image.jpg',
        'button_text' => 'Shop Now',
        'button_url' => '/products',
        'is_active' => true,
        'order' => 1,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Test Banner')
             ->assertSee('Test Subtitle')
             ->assertSee('Shop Now');
});

test('homepage displays featured products section', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Featured Product',
        'slug' => 'featured-product',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => true,
        'is_featured' => true,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Featured Products')
             ->assertSee('Featured Product');
});

test('homepage displays new arrivals section', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'New Product',
        'slug' => 'new-product',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => true,
        'created_at' => now(),
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('New Arrivals')
             ->assertSee('New Product');
});

test('homepage displays best items section', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Best Product',
        'slug' => 'best-product',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => true,
        'sales_count' => 10,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Best Items')
             ->assertSee('Best Product');
});

test('homepage displays all products section', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'All Products Item',
        'slug' => 'all-products-item',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => true,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('All Products')
             ->assertSee('All Products Item');
});

test('homepage displays categories section', function () {
    Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Test Category');
});

test('homepage displays brands section', function () {
    Brand::create([
        'name' => 'Test Brand',
        'slug' => 'test-brand',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Test Brand');
});

test('homepage has proper meta tags and structure', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('<meta name="csrf-token"', false)
             ->assertSee('<title>', false)
             ->assertSee('viewport', false)
             ->assertSee('tailwindcss', false);
});

test('homepage search functionality works', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Search for products')
             ->assertSee('type="search"', false);
});

test('homepage cart link is present', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee(route('cart.index'))
             ->assertSee('cart-count');
});

test('homepage navigation links work', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee(route('home'))
             ->assertSee('SSB Leather');
});

test('homepage is responsive with proper classes', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('max-w-7xl')
             ->assertSee('mx-auto')
             ->assertSee('px-4')
             ->assertSee('lg:grid-cols-12');
});

test('homepage handles empty data gracefully', function () {
    // Test with no products, banners, etc.
    $response = $this->get(route('home'));

    $response->assertStatus(200)
             ->assertSee('Welcome to Our Store') // Fallback banner content
             ->assertSee('No Featured Products Available'); // Empty state messages
});

test('homepage loads within reasonable time', function () {
    $startTime = microtime(true);

    $response = $this->get(route('home'));

    $endTime = microtime(true);
    $loadTime = ($endTime - $startTime) * 1000; // Convert to milliseconds

    $response->assertStatus(200);

    // Assert that page loads within 2 seconds (reasonable for a homepage)
    expect($loadTime)->toBeLessThan(2000);
});
