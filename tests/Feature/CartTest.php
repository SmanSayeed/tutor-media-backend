<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cart page displays correctly for authenticated user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('cart.index'));

    $response->assertStatus(200)
             ->assertSee('Shopping Cart')
             ->assertSee('Your cart is empty');
});

test('cart page shows items correctly', function () {
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

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'unit_price' => 100.00,
        'total_price' => 200.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('cart.index'));

    $response->assertStatus(200)
             ->assertSee('Test Product')
             ->assertSee('৳200.00') // Item total
             ->assertSee('৳200.00') // Subtotal
             ->assertSee('৳100') // Shipping
             ->assertSee('৳300'); // Total
});

test('cart calculations are accurate', function () {
    $user = User::factory()->create();
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product1 = Product::create([
        'category_id' => $category->id,
        'name' => 'Product 1',
        'slug' => 'product-1',
        'description' => 'Test description',
        'price' => 50.00,
        'is_active' => true,
    ]);

    $product2 = Product::create([
        'category_id' => $category->id,
        'name' => 'Product 2',
        'slug' => 'product-2',
        'description' => 'Test description',
        'price' => 75.00,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product1->id,
        'quantity' => 2,
        'unit_price' => 50.00,
        'total_price' => 100.00,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product2->id,
        'quantity' => 1,
        'unit_price' => 75.00,
        'total_price' => 75.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('cart.index'));

    $response->assertStatus(200)
             ->assertSee('৳175.00') // Subtotal (100 + 75)
             ->assertSee('৳100') // Shipping
             ->assertSee('৳275'); // Total (175 + 100)
});

test('cart handles free shipping for orders over 1000', function () {
    $user = User::factory()->create();
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Expensive Product',
        'slug' => 'expensive-product',
        'description' => 'Test description',
        'price' => 1200.00,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 1200.00,
        'total_price' => 1200.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('cart.index'));

    $response->assertStatus(200)
             ->assertSee('Free') // Free shipping
             ->assertSee('৳1200'); // Total equals subtotal
});

test('cart quantity update works via AJAX', function () {
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

    $cartItem = Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 100.00,
        'total_price' => 100.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->patchJson(route('cart.update', $cartItem->id), [
        'quantity' => 3,
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'item_total' => '300.00',
                 'cart_total' => '300.00',
             ]);

    $cartItem->refresh();
    expect($cartItem->quantity)->toBe(3);
    expect($cartItem->total_price)->toBe(300.00);
});

test('cart item removal works via AJAX', function () {
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

    $cartItem = Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 100.00,
        'total_price' => 100.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->deleteJson(route('cart.remove', $cartItem->id));

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'cart_total' => '0.00',
                 'cart_count' => 0,
             ]);

    $this->assertDatabaseMissing('carts', ['id' => $cartItem->id]);
});

test('cart handles variants correctly', function () {
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

    $variant = ProductVariant::create([
        'product_id' => $product->id,
        'size_id' => 1,
        'color_id' => 1,
        'price' => 120.00,
        'stock_quantity' => 10,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variant_id' => $variant->id,
        'quantity' => 1,
        'unit_price' => 120.00,
        'total_price' => 120.00,
        'product_attributes' => ['color' => 'Red', 'size' => 'M'],
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('cart.index'));

    $response->assertStatus(200)
             ->assertSee('Test Product')
             ->assertSee('Red')
             ->assertSee('M')
             ->assertSee('৳120.00');
});

test('cart count updates correctly', function () {
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

    // Add item to cart
    $response = $this->actingAs($user)->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $response->assertStatus(200)
             ->assertJson(['cart_count' => 2]);

    // Check cart count endpoint
    $countResponse = $this->getJson(route('cart.count'));
    $countResponse->assertStatus(200)
                  ->assertJson(['cart_count' => 2]);
});

test('cart handles guest users with sessions', function () {
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

    // Add item as guest
    $response = $this->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(200)
             ->assertJson(['cart_count' => 1]);

    // Check that session cart works
    $this->assertDatabaseHas('carts', [
        'product_id' => $product->id,
        'quantity' => 1,
        'session_id' => session('cart_session_id'),
    ]);
});

test('cart prevents duplicate items for same product without variant', function () {
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

    // Add same product twice
    $this->actingAs($user)->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this->actingAs($user)->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    // Should have only one cart item with combined quantity
    $cartItems = Cart::where('user_id', $user->id)->get();
    expect($cartItems)->toHaveCount(1);
    expect($cartItems->first()->quantity)->toBe(3);
    expect($cartItems->first()->total_price)->toBe(300.00);
});

test('cart clear functionality works', function () {
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

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 100.00,
        'total_price' => 100.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->deleteJson(route('cart.clear'));

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'Cart cleared successfully!',
             ]);

    $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);
});

test('cart validates quantity limits', function () {
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

    $cartItem = Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 100.00,
        'total_price' => 100.00,
        'is_active' => true,
    ]);

    // Try to update to invalid quantity
    $response = $this->actingAs($user)->patchJson(route('cart.update', $cartItem->id), [
        'quantity' => 200, // Over limit
    ]);

    $response->assertStatus(500); // Should fail
});

test('cart handles inactive products', function () {
    $user = User::factory()->create();
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Inactive Product',
        'slug' => 'inactive-product',
        'description' => 'Test description',
        'price' => 100.00,
        'is_active' => false, // Inactive
    ]);

    $response = $this->actingAs($user)->postJson(route('cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(500); // Should fail for inactive product
});
