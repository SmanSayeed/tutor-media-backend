<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('checkout page displays cart items correctly', function () {
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
    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'unit_price' => 100.00,
        'total_price' => 200.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('checkout.index'));

    $response->assertStatus(200)
             ->assertSee('Test Product')
             ->assertSee('৳200.00')
             ->assertSee('Subtotal (2 items)');
});

test('checkout calculates shipping correctly', function () {
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
        'price' => 500.00, // Under 1000, should have shipping
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 500.00,
        'total_price' => 500.00,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('checkout.index'));

    $response->assertStatus(200)
             ->assertSee('৳100') // Shipping cost
             ->assertSee('৳600'); // Total (500 + 100)
});

test('checkout shows free shipping for orders over 1000', function () {
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
        'price' => 1200.00, // Over 1000, should have free shipping
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

    $response = $this->actingAs($user)->get(route('checkout.index'));

    $response->assertStatus(200)
             ->assertSee('Free') // Free shipping
             ->assertSee('৳1200.00'); // Total equals subtotal
});

test('checkout processes order successfully', function () {
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

    $orderData = [
        'shipping_address' => '123 Test Street, Dhaka, 1200',
        'division' => 'Dhaka',
        'district' => 'Dhaka',
        'postal_code' => '1200',
        'country' => 'Bangladesh',
        'payment_method' => 'cash_on_delivery',
        'notes' => 'Test order',
    ];

    $response = $this->actingAs($user)->postJson(route('checkout.process'), $orderData);

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'Order placed successfully!',
             ]);

    // Verify order was created
    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'total_amount' => 200.00, // 100 + 100 shipping
        'payment_method' => 'cash_on_delivery',
        'status' => 'pending',
    ]);

    // Verify cart was cleared
    $this->assertDatabaseMissing('carts', [
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);
});

test('checkout handles coupon discounts correctly', function () {
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
        'price' => 200.00,
        'is_active' => true,
    ]);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 200.00,
        'total_price' => 200.00,
        'is_active' => true,
    ]);

    // Simulate coupon session
    session(['coupon' => [
        'code' => 'TEST10',
        'discount' => 20.00, // Fixed discount
    ]]);

    $response = $this->actingAs($user)->get(route('checkout.index'));

    $response->assertStatus(200)
             ->assertSee('৳200.00') // Subtotal
             ->assertSee('৳100') // Shipping
             ->assertSee('৳280.00'); // Total (200 + 100 - 20)
});

test('checkout validates required fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson(route('checkout.process'), []);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['shipping_address', 'payment_method']);
});

test('checkout prevents admin users from placing orders', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->postJson(route('checkout.process'), [
        'shipping_address' => 'Admin Address',
        'division' => 'Dhaka',
        'district' => 'Dhaka',
        'postal_code' => '1200',
        'country' => 'Bangladesh',
        'payment_method' => 'cash_on_delivery',
    ]);

    $response->assertStatus(403)
             ->assertJson([
                 'success' => false,
                 'message' => 'Admin users are not allowed to place orders.',
             ]);
});
