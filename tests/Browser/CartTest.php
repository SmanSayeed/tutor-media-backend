<?php

namespace Tests\Browser;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CartTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Comprehensive cart functionality test covering all features in a single execution.
     * Tests adding items, updating quantities, removing items, totals calculation,
     * empty states, and edge cases sequentially.
     */
    public function testCompleteCartFunctionality()
    {
        // Create comprehensive test data
        $testData = $this->createComprehensiveTestData();

        $this->browse(function (Browser $browser) use ($testData) {
            $user = $testData['user'];
            $products = $testData['products'];

            // === TEST 1: Start with empty cart ===
            $browser->loginAs($user)
                    ->visit(route('cart.index'))
                    ->assertSee('Shopping Cart')
                    ->assertSee('Your cart is empty')
                    ->assertSee('Continue Shopping')
                    ->assertPresent('a[href="' . route('home') . '"]');

            // === TEST 2: Add first product to cart ===
            $browser->visit(route('products.show', $products[0]->slug))
                    ->assertSee($products[0]->name)
                    ->assertSee('৳2,500') // Sale price (without .00)
                    ->assertPresent('#add-to-cart')
                    ->press('#add-to-cart')
                    ->pause(3000) // Wait for AJAX request
                    ->assertSee('Product added to cart successfully');

            // Check cart count in header
            $browser->assertPresent('.cart-count')
                    ->assertSeeIn('.cart-count', '1');

            // Verify database state
            $this->assertDatabaseHas('carts', [
                'user_id' => $user->id,
                'product_id' => $products[0]->id,
                'quantity' => 1,
                'unit_price' => 2000.00, // Sale price
                'total_price' => 2000.00,
            ]);

            // === TEST 3: Add second product to cart ===
            $browser->visit(route('products.show', $products[1]->slug))
                    ->assertSee($products[1]->name)
                    ->assertSee('৳1,800')
                    ->assertPresent('#add-to-cart')
                    ->press('#add-to-cart')
                    ->pause(2000) // Wait for AJAX request
                    ->assertSee('Product added to cart successfully');

            // Check cart count updated to 2
            $browser->assertSeeIn('.cart-count', '2');

            // === TEST 4: Navigate to cart and verify items display ===
            $browser->visit(route('cart.index'))
                    ->assertSee('Shopping Cart')
                    ->assertSee('2 item(s) in your cart')
                    ->assertSee($products[0]->name)
                    ->assertSee($products[1]->name)
                    ->assertSee('৳2,500.00') // First product price
                    ->assertSee('৳1,800') // Second product price
                    ->assertSee('৳4,300') // Subtotal (2500 + 1800)
                    ->assertSee('৳100') // Shipping
                    ->assertSee('৳4,400'); // Total (4300 + 100)

            // === TEST 5: Update quantity of first item (increase) ===
            $cartItem1 = Cart::where('user_id', $user->id)->where('product_id', $products[0]->id)->first();
            $browser->click('.cart-qty-plus[data-cart-id="' . $cartItem1->id . '"]')
                    ->waitForText('Cart updated successfully')
                    ->assertSee('Cart updated successfully')
                    ->assertSee('৳5,000') // Item total (2500 * 2)
                    ->assertInputValue('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '2')
                    ->assertSee('৳6,100') // Subtotal (5000 + 1800)
                    ->assertSee('৳6,200'); // Total (6100 + 100)

            // Verify database state
            $cartItem1->refresh();
            $this->assertEquals(2, $cartItem1->quantity);
            $this->assertEquals(5000.00, $cartItem1->total_price);

            // === TEST 6: Update quantity of second item (decrease) ===
            $cartItem2 = Cart::where('user_id', $user->id)->where('product_id', $products[1]->id)->first();
            $browser->click('.cart-qty-minus[data-cart-id="' . $cartItem2->id . '"]')
                    ->waitForText('Cart updated successfully')
                    ->assertSee('Cart updated successfully')
                    ->assertInputValue('.cart-qty-input[data-cart-id="' . $cartItem2->id . '"]', '1')
                    ->assertSee('৳5,000') // Subtotal (5000 + 1800)
                    ->assertSee('৳5,100'); // Total (5000 + 1800 + 100)

            // === TEST 7: Test quantity input field directly ===
            $browser->type('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '3')
                    ->keys('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '{enter}')
                    ->waitForText('Cart updated successfully')
                    ->assertSee('Cart updated successfully')
                    ->assertInputValue('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '3')
                    ->assertSee('৳7,500') // Item total (2500 * 3)
                    ->assertSee('৳7,800') // Subtotal (7500 + 1800)
                    ->assertSee('৳7,900'); // Total (7800 + 100)

            // === TEST 8: Test free shipping threshold ===
            $browser->type('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '5')
                    ->keys('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '{enter}')
                    ->waitForText('Cart updated successfully')
                    ->assertSee('Cart updated successfully')
                    ->assertSee('৳12,500') // Item total (2500 * 5)
                    ->assertSee('৳14,300') // Subtotal (12500 + 1800)
                    ->assertSee('Free') // Free shipping over 1000
                    ->assertSee('৳14,300'); // Total (14300 + 0)

            // === TEST 9: Remove second item ===
            $browser->click('.cart-remove[data-cart-id="' . $cartItem2->id . '"]')
                    ->waitForText('Item removed from cart')
                    ->assertSee('Item removed from cart')
                    ->assertDontSee($products[1]->name)
                    ->assertSee('1 item(s) in your cart')
                    ->assertSee('৳12,500') // Subtotal
                    ->assertSee('Free') // Still free shipping
                    ->assertSee('৳12,500'); // Total

            // Verify database state
            $this->assertDatabaseMissing('carts', ['id' => $cartItem2->id]);

            // === TEST 10: Test quantity limits (max 100) ===
            $browser->type('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '101')
                    ->keys('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '{enter}')
                    ->pause(1000) // Wait for potential error
                    ->assertInputValue('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '5'); // Should revert

            // === TEST 11: Test minimum quantity (1) ===
            $browser->click('.cart-qty-minus[data-cart-id="' . $cartItem1->id . '"]')
                    ->waitForText('Cart updated successfully')
                    ->assertInputValue('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '4');

            // Try to go below 1
            $browser->type('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '0')
                    ->keys('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '{enter}')
                    ->pause(1000)
                    ->assertInputValue('.cart-qty-input[data-cart-id="' . $cartItem1->id . '"]', '4'); // Should revert

            // === TEST 12: Remove last item ===
            $browser->click('.cart-remove[data-cart-id="' . $cartItem1->id . '"]')
                    ->waitForText('Item removed from cart')
                    ->assertSee('Item removed from cart')
                    ->assertDontSee($products[0]->name)
                    ->assertSee('Your cart is empty')
                    ->assertSee('Continue Shopping');

            // Verify database state - cart should be empty
            $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);

            // === TEST 13: Test out of stock product ===
            $outOfStockProduct = $testData['out_of_stock_product'];
            $browser->visit(route('products.show', $outOfStockProduct->slug))
                    ->assertSee('Out of Stock')
                    ->assertPresent('#add-to-cart:disabled');

            // === TEST 14: Test inactive product ===
            $inactiveProduct = $testData['inactive_product'];
            $browser->visit(route('products.show', $inactiveProduct->slug))
                    ->assertSee('Product not found');

            // === TEST 15: Test product with limited stock ===
            $limitedStockProduct = $testData['limited_stock_product'];
            $browser->visit(route('products.show', $limitedStockProduct->slug))
                    ->assertSee($limitedStockProduct->name)
                    ->assertNotPresent('#add-to-cart:disabled');

            // Add limited stock product
            $browser->press('#add-to-cart')
                    ->pause(2000) // Wait for AJAX request
                    ->assertSee('Product added to cart successfully');

            // Verify cart has the item
            $browser->visit(route('cart.index'))
                    ->assertSee($limitedStockProduct->name)
                    ->assertSee('৳50');

            // === TEST 16: Test cart persistence across page refreshes ===
            $browser->refresh()
                    ->assertSee($limitedStockProduct->name)
                    ->assertSee('৳50');

            // === TEST 17: Clear cart completely ===
            $cartItem = Cart::where('user_id', $user->id)->first();
            $browser->click('.cart-remove[data-cart-id="' . $cartItem->id . '"]')
                    ->waitForText('Item removed from cart')
                    ->assertSee('Your cart is empty');

            // Final verification - cart should be completely empty
            $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);
        });
    }

    /**
     * Helper method to create comprehensive test data for cart testing.
     * Creates all necessary models with realistic data including edge cases.
     */
    private function createComprehensiveTestData()
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

        // Create products with different scenarios
        $product1 = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Running Shoes',
            'slug' => 'running-shoes',
            'description' => 'Comfortable running shoes',
            'price' => 3000.00,
            'sale_price' => 2500.00,
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

        // Out of stock product
        $outOfStockProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Out of Stock Product',
            'slug' => 'out-of-stock-product',
            'description' => 'This product is out of stock',
            'price' => 100.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-3.jpg',
            'stock_quantity' => 0,
        ]);

        // Inactive product
        $inactiveProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Inactive Product',
            'slug' => 'inactive-product',
            'description' => 'This product is inactive',
            'price' => 100.00,
            'is_active' => false,
            'main_image' => '/images/products/shoe-4.jpg',
            'stock_quantity' => 10,
        ]);

        // Limited stock product
        $limitedStockProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Limited Stock Product',
            'slug' => 'limited-stock-product',
            'description' => 'Limited stock available',
            'price' => 50.00,
            'is_active' => true,
            'main_image' => '/images/products/shoe-5.jpg',
            'stock_quantity' => 5,
        ]);

        return [
            'user' => $user,
            'category' => $category,
            'brand' => $brand,
            'products' => [$product1, $product2],
            'out_of_stock_product' => $outOfStockProduct,
            'inactive_product' => $inactiveProduct,
            'limited_stock_product' => $limitedStockProduct,
        ];
    }
}
