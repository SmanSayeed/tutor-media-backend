<?php

namespace Tests\Browser;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful checkout process with valid form data.
     * Verifies that order is created, cart is cleared, and user is redirected to confirmation page.
     *
     * @return void
     */
    public function testSuccessfulCheckout()
    {
        // Create test data
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
            'price' => 500.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 10,
        ]);

        // Add item to cart
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 500.00,
            'total_price' => 1000.00,
            'is_active' => true,
        ]);

        $this->browse(function (Browser $browser) use ($user, $product) {
            // Login and navigate to checkout
            $browser->loginAs($user)
                    ->visit(route('checkout.index'))
                    ->assertSee('Checkout')
                    ->assertSee($product->name)
                    ->assertSee('৳1,000.00') // Subtotal
                    ->assertSee('৳100') // Shipping
                    ->assertSee('৳1,100.00'); // Total

            // Fill checkout form
            $browser->type('input[name="shipping_address[name]"]', 'John Doe')
                    ->type('input[name="shipping_address[email]"]', 'john@example.com')
                    ->type('input[name="shipping_address[phone]"]', '+8801712345678')
                    ->type('textarea[name="shipping_address[address]"]', '123 Test Street')
                    ->type('input[name="shipping_address[city]"]', 'Dhaka')
                    ->type('input[name="shipping_address[postal_code]"]', '1200')
                    ->type('textarea[name="notes"]', 'Test order notes')
                    ->press('#place-order')
                    ->waitForText('Order placed successfully!')
                    ->assertSee('Order placed successfully!');

            // Verify redirect to order confirmation
            $browser->assertPathIs('/orders/*')
                    ->assertSee('Order Confirmation')
                    ->assertSee('Order #');

            // Verify database state
            $this->assertDatabaseHas('orders', [
                'user_id' => $user->id,
                'status' => 'pending',
                'payment_method' => 'cash_on_delivery',
                'total_amount' => 1100.00,
            ]);

            $this->assertDatabaseHas('order_items', [
                'product_id' => $product->id,
                'quantity' => 2,
                'unit_price' => 500.00,
                'total_price' => 1000.00,
            ]);

            // Verify cart is cleared
            $this->assertDatabaseMissing('carts', [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);

            // Verify stock is reduced
            $product->refresh();
            $this->assertEquals(8, $product->stock_quantity);
        });
    }

    /**
     * Test checkout with empty cart.
     * Verifies that user is redirected to cart page with error message.
     *
     * @return void
     */
    public function testCheckoutWithEmptyCart()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            // Login and try to access checkout with empty cart
            $browser->loginAs($user)
                    ->visit(route('checkout.index'))
                    ->assertPathIs('/cart')
                    ->assertSee('Your cart is empty');
        });
    }

    /**
     * Test checkout form validation.
     * Verifies that required fields are validated and error messages are displayed.
     *
     * @return void
     */
    public function testCheckoutFormValidation()
    {
        // Create test data
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
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 10,
        ]);

        // Add item to cart
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
            'is_active' => true,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Login and navigate to checkout
            $browser->loginAs($user)
                    ->visit(route('checkout.index'))
                    ->assertSee('Checkout');

            // Try to submit empty form
            $browser->press('#place-order')
                    ->waitForText('The shipping address field is required')
                    ->assertSee('The shipping address field is required');

            // Fill partial data and test individual field validation
            $browser->type('input[name="shipping_address[name]"]', 'John')
                    ->press('#place-order')
                    ->assertSee('The shipping address field is required');

            // Test invalid email format
            $browser->type('input[name="shipping_address[email]"]', 'invalid-email')
                    ->press('#place-order')
                    ->assertSee('The email must be a valid email address');

            // Test invalid phone number
            $browser->type('input[name="shipping_address[phone]"]', 'invalid-phone')
                    ->press('#place-order')
                    ->assertSee('The phone format is invalid');
        });
    }

    /**
     * Test checkout with out of stock item.
     * Verifies that checkout is blocked when item becomes out of stock.
     *
     * @return void
     */
    public function testCheckoutWithOutOfStockItem()
    {
        // Create test data
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
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 1, // Only 1 in stock
        ]);

        // Add item to cart with quantity exceeding stock
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2, // Request 2 but only 1 available
            'unit_price' => 100.00,
            'total_price' => 200.00,
            'is_active' => true,
        ]);

        $this->browse(function (Browser $browser) use ($user, $product) {
            // Login and navigate to checkout
            $browser->loginAs($user)
                    ->visit(route('checkout.index'))
                    ->assertSee('Checkout');

            // Fill form and submit
            $browser->type('input[name="shipping_address[name]"]', 'John Doe')
                    ->type('input[name="shipping_address[email]"]', 'john@example.com')
                    ->type('input[name="shipping_address[phone]"]', '+8801712345678')
                    ->type('textarea[name="shipping_address[address]"]', '123 Test Street')
                    ->type('input[name="shipping_address[city]"]', 'Dhaka')
                    ->type('input[name="shipping_address[postal_code]"]', '1200')
                    ->press('#place-order')
                    ->waitForText('Insufficient stock')
                    ->assertSee('Insufficient stock for Test Product');
        });
    }

    /**
     * Test order confirmation page display.
     * Verifies that order details are correctly displayed on confirmation page.
     *
     * @return void
     */
    public function testOrderConfirmationPage()
    {
        // Create test data
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
            'price' => 500.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 10,
        ]);

        // Create order directly
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 1000.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 100.00,
            'discount_amount' => 0.00,
            'total_amount' => 1100.00,
            'currency' => 'BDT',
            'payment_status' => 'pending',
            'payment_method' => 'cash_on_delivery',
            'billing_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '+8801712345678',
                'address' => '123 Test Street',
                'city' => 'Dhaka',
                'postal_code' => '1200',
            ],
            'shipping_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '+8801712345678',
                'address' => '123 Test Street',
                'city' => 'Dhaka',
                'postal_code' => '1200',
            ],
            'shipping_method' => 'standard',
            'notes' => 'Test order notes',
        ]);

        // Create order item
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'quantity' => 2,
            'unit_price' => 500.00,
            'total_price' => 1000.00,
            'product_attributes' => [],
        ]);

        $this->browse(function (Browser $browser) use ($user, $order, $product) {
            // Login and visit order confirmation page
            $browser->loginAs($user)
                    ->visit(route('orders.show', $order))
                    ->assertSee('Order Confirmation')
                    ->assertSee('Order #' . $order->order_number)
                    ->assertSee('Pending')
                    ->assertSee('Cash on Delivery')
                    ->assertSee($product->name)
                    ->assertSee('Quantity: 2')
                    ->assertSee('৳500.00') // Unit price
                    ->assertSee('৳1,000.00') // Item total
                    ->assertSee('৳1,100.00') // Order total
                    ->assertSee('John Doe')
                    ->assertSee('john@example.com')
                    ->assertSee('+8801712345678')
                    ->assertSee('123 Test Street')
                    ->assertSee('Dhaka')
                    ->assertSee('1200')
                    ->assertSee('Test order notes');
        });
    }

    /**
     * Test buy now functionality from product page.
     * Verifies that user can place order directly from product page without adding to cart.
     *
     * @return void
     */
    public function testBuyNowFunctionality()
    {
        // Create test data
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
            'price' => 300.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 5,
        ]);

        $this->browse(function (Browser $browser) use ($user, $product) {
            // Login and visit product page
            $browser->loginAs($user)
                    ->visit(route('products.show', $product->slug))
                    ->assertSee($product->name)
                    ->assertSee('৳300.00');

            // Click buy now button (assuming it exists)
            $browser->press('button:contains("Select options")')
                    ->waitForText('Order placed successfully!')
                    ->assertSee('Order placed successfully!');

            // Verify redirect to order confirmation
            $browser->assertPathIs('/orders/*')
                    ->assertSee('Order Confirmation');

            // Verify database state
            $this->assertDatabaseHas('orders', [
                'user_id' => $user->id,
                'status' => 'pending',
                'payment_method' => 'cash_on_delivery',
                'total_amount' => 400.00, // 300 + 100 shipping
            ]);

            $this->assertDatabaseHas('order_items', [
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => 300.00,
                'total_price' => 300.00,
            ]);

            // Verify stock is reduced
            $product->refresh();
            $this->assertEquals(4, $product->stock_quantity);
        });
    }

    /**
     * Test checkout with coupon discount.
     * Verifies that coupon discount is applied correctly during checkout.
     *
     * @return void
     */
    public function testCheckoutWithCouponDiscount()
    {
        // Create test data
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
            'price' => 500.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 10,
        ]);

        // Add item to cart
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 500.00,
            'total_price' => 500.00,
            'is_active' => true,
        ]);

        // Note: Coupon functionality would need to be implemented in the application
        // This test assumes coupon session data is set
        session(['coupon' => [
            'code' => 'TEST10',
            'discount' => 50.00,
        ]]);

        $this->browse(function (Browser $browser) use ($user, $product) {
            // Login and navigate to checkout
            $browser->loginAs($user)
                    ->visit(route('checkout.index'))
                    ->assertSee('Checkout')
                    ->assertSee($product->name)
                    ->assertSee('৳500.00') // Subtotal
                    ->assertSee('৳50.00') // Discount
                    ->assertSee('৳100') // Shipping
                    ->assertSee('৳550.00'); // Total (500 - 50 + 100)

            // Fill form and submit
            $browser->type('input[name="shipping_address[name]"]', 'John Doe')
                    ->type('input[name="shipping_address[email]"]', 'john@example.com')
                    ->type('input[name="shipping_address[phone]"]', '+8801712345678')
                    ->type('textarea[name="shipping_address[address]"]', '123 Test Street')
                    ->type('input[name="shipping_address[city]"]', 'Dhaka')
                    ->type('input[name="shipping_address[postal_code]"]', '1200')
                    ->press('#place-order')
                    ->waitForLocation('/orders/*')
                    ->assertPathBeginsWith('/orders/');

            // Verify database state with discount
            $this->assertDatabaseHas('orders', [
                'user_id' => $user->id,
                'discount_amount' => 50.00,
                'coupon_code' => 'TEST10',
                'total_amount' => 550.00,
            ]);
        });
    }

    /**
     * Test checkout with free shipping threshold.
     * Verifies that shipping is free when order total exceeds threshold.
     *
     * @return void
     */
    public function testCheckoutFreeShipping()
    {
        // Create test data
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
            'price' => 600.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 10,
        ]);

        // Add item to cart with subtotal > 1000 for free shipping
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2, // 1200 subtotal
            'unit_price' => 600.00,
            'total_price' => 1200.00,
            'is_active' => true,
        ]);

        $this->browse(function (Browser $browser) use ($user, $product) {
            // Login and navigate to checkout
            $browser->loginAs($user)
                    ->visit(route('checkout.index'))
                    ->assertSee('Checkout')
                    ->assertSee($product->name)
                    ->assertSee('৳1,200.00') // Subtotal
                    ->assertSee('Free') // Free shipping
                    ->assertSee('৳1,200.00'); // Total (no shipping)

            // Fill form and submit
            $browser->type('input[name="shipping_address[name]"]', 'John Doe')
                    ->type('input[name="shipping_address[email]"]', 'john@example.com')
                    ->type('input[name="shipping_address[phone]"]', '+8801712345678')
                    ->type('textarea[name="shipping_address[address]"]', '123 Test Street')
                    ->type('input[name="shipping_address[city]"]', 'Dhaka')
                    ->type('input[name="shipping_address[postal_code]"]', '1200')
                    ->press('#place-order')
                    ->waitForText('Order placed successfully!')
                    ->assertSee('Order placed successfully!');

            // Verify database state with free shipping
            $this->assertDatabaseHas('orders', [
                'user_id' => $user->id,
                'subtotal' => 1200.00,
                'shipping_amount' => 0.00,
                'total_amount' => 1200.00,
            ]);
        });
    }

    /**
     * Helper method to create comprehensive test data for checkout testing.
     * Creates all necessary models with realistic data.
     *
     * @return array
     */
    private function createTestData()
    {
        // Create category
        $category = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true,
        ]);

        // Create brand
        $brand = Brand::create([
            'name' => 'Nike',
            'slug' => 'nike',
            'logo' => '/images/brands/nike-logo.png',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create user
        $user = User::factory()->create();

        // Create products
        $product1 = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Running Shoes',
            'slug' => 'running-shoes',
            'description' => 'Comfortable running shoes',
            'price' => 2500.00,
            'sale_price' => 2000.00,
            'is_active' => true,
            'is_featured' => true,
            'main_image' => '/images/products/shoe-1.jpg',
            'stock_quantity' => 20,
            'sales_count' => 15,
            'view_count' => 100,
        ]);

        $product2 = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Casual Sneakers',
            'slug' => 'casual-sneakers',
            'description' => 'Stylish casual sneakers',
            'price' => 1800.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-2.jpg',
            'stock_quantity' => 15,
        ]);

        return [
            'user' => $user,
            'category' => $category,
            'brand' => $brand,
            'products' => [$product1, $product2],
        ];
    }
}
