<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('product page displays correctly', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'This is a detailed product description for testing.',
        'price' => 150.00,
        'sale_price' => 120.00,
        'is_active' => true,
        'main_image' => 'test-image.jpg',
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertSee('Test Product')
             ->assertSee('This is a detailed product description')
             ->assertSee('৳120') // Sale price
             ->assertSee('৳150'); // Original price
});

test('product page shows variants correctly', function () {
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
        'is_active' => true,
    ]);

    ProductVariant::create([
        'product_id' => $product->id,
        'size_id' => 1,
        'color_id' => 1,
        'price' => 110.00,
        'stock_quantity' => 10,
        'is_active' => true,
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertSee('Test Product');
});

test('product page handles add to cart', function () {
    $user = User::factory()->create();

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
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'Product added to cart successfully!',
             ]);

    $this->assertDatabaseHas('carts', [
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'unit_price' => 100.00,
        'total_price' => 200.00,
    ]);
});

test('product page shows related products', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product1 = Product::create([
        'category_id' => $category->id,
        'name' => 'Main Product',
        'slug' => 'main-product',
        'description' => 'Main product description',
        'price' => 100.00,
        'is_active' => true,
    ]);

    $product2 = Product::create([
        'category_id' => $category->id,
        'name' => 'Related Product',
        'slug' => 'related-product',
        'description' => 'Related product description',
        'price' => 80.00,
        'is_active' => true,
    ]);

    $response = $this->get(route('products.show', $product1->slug));

    $response->assertStatus(200)
             ->assertSee('Suggested Products')
             ->assertSee('Related Product');
});

test('product page increments view count', function () {
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
        'is_active' => true,
        'view_count' => 5,
    ]);

    $this->get(route('products.show', $product->slug));

    $product->refresh();
    expect($product->view_count)->toBe(6);
});

test('product page handles non-existent product', function () {
    $response = $this->get(route('products.show', 'non-existent-product'));

    $response->assertRedirect(route('home'));
});

test('product page shows proper pricing display', function () {
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
        'price' => 200.00,
        'sale_price' => 150.00,
        'is_active' => true,
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertSee('৳150') // Sale price
             ->assertSee('৳200'); // Original price with strikethrough
});

test('product page has proper meta information', function () {
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
        'is_active' => true,
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertSee('<meta name="csrf-token"', false)
             ->assertSee('Test Product')
             ->assertSee('Select options'); // Add to cart button
});

test('product page handles out of stock products', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Out of Stock Product',
        'slug' => 'out-of-stock-product',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => false, // Inactive = out of stock
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertRedirect(route('home'));
});

test('product page shows product images correctly', function () {
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
        'is_active' => true,
        'main_image' => 'main-image.jpg',
    ]);

    // Create product images
    $product->images()->create([
        'image_path' => 'image1.jpg',
        'is_primary' => true,
        'sort_order' => 1,
    ]);

    $product->images()->create([
        'image_path' => 'image2.jpg',
        'is_primary' => false,
        'sort_order' => 2,
    ]);

    $response = $this->get(route('products.show', $product->slug));

    $response->assertStatus(200)
             ->assertSee('main-image.jpg')
             ->assertSee('image1.jpg')
             ->assertSee('image2.jpg');
});

test('product page handles buy now functionality', function () {
    $user = User::factory()->create();

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
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->postJson(route('checkout.buy-now'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'Order placed successfully!',
             ]);
});

test('product page validates quantity limits', function () {
    $user = User::factory()->create();

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
        'is_active' => true,
    ]);

    // Test quantity too high
    $response = $this->actingAs($user)->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 200, // Over limit
    ]);

    $response->assertStatus(422); // Validation error
});
