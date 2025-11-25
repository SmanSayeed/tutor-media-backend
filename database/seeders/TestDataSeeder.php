<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed prerequisite data for products
        $this->call([
            BrandSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            ChildCategorySeeder::class,
        ]);

        // Create test users and customers
        $this->createTestUsers();

        // Create additional customers for testing
        Customer::factory(20)->create();

        // Create products with variants (using existing seeders)
        $this->call([
            ProductSeeder::class,
            ProductVariantSeeder::class,
        ]);

        // Create orders and order items
        $this->createOrders();

        // Create reviews for products
        $this->createReviews();

        // Create wishlist items
        $this->createWishlists();

        // Create cart items
        $this->createCartItems();
    }

    /**
     * Create test users with specific roles for testing.
     */
    private function createTestUsers(): void
    {
        // Create test admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Test Admin',
                'role' => 'admin',
            ]
        );

        Customer::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'user_id' => $admin->id,
                'first_name' => 'Test',
                'last_name' => 'Admin',
            ]
        );

        // Create test customer user
        $customer = User::updateOrCreate(
            ['email' => 'customer@test.com'],
            [
                'name' => 'Test Customer',
                'role' => 'customer',
            ]
        );

        Customer::updateOrCreate(
            ['email' => 'customer@test.com'],
            [
                'user_id' => $customer->id,
                'first_name' => 'Test',
                'last_name' => 'Customer',
            ]
        );

        // Create test vendor user
        $vendor = User::updateOrCreate(
            ['email' => 'vendor@test.com'],
            [
                'name' => 'Test Vendor',
                'role' => 'vendor',
            ]
        );

        Customer::updateOrCreate(
            ['email' => 'vendor@test.com'],
            [
                'user_id' => $vendor->id,
                'first_name' => 'Test',
                'last_name' => 'Vendor',
            ]
        );
    }

    /**
     * Create orders with various statuses for testing.
     */
    private function createOrders(): void
    {
        $customers = Customer::all();

        // Create orders with different statuses
        foreach (['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $status) {
            $orders = Order::factory(rand(3, 8))->create([
                'status' => $status,
                'customer_id' => $customers->random()->id,
            ]);

            // Create order items for each order
            foreach ($orders as $order) {
                $productCount = rand(1, 4);
                $products = Product::inRandomOrder()->take($productCount)->get();

                foreach ($products as $product) {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'unit_price' => $product->price,
                    ]);
                }

                // Update order totals based on items
                $this->updateOrderTotals($order);
            }
        }

        // Create some paid orders
        $paidOrders = Order::factory(5)->paid()->create([
            'customer_id' => $customers->random()->id,
        ]);

        foreach ($paidOrders as $order) {
            $productCount = rand(1, 3);
            $products = Product::inRandomOrder()->take($productCount)->get();

            foreach ($products as $product) {
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->price,
                ]);
            }

            $this->updateOrderTotals($order);
        }
    }

    /**
     * Update order totals based on order items.
     */
    private function updateOrderTotals(Order $order): void
    {
        $subtotal = $order->items->sum('total_price');
        $taxAmount = $subtotal * 0.1; // 10% tax
        $shippingAmount = rand(5, 25); // Random shipping
        $totalAmount = $subtotal + $taxAmount + $shippingAmount;

        $order->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $totalAmount,
        ]);
    }

    /**
     * Create reviews for products.
     */
    private function createReviews(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        // Create reviews for random products
        foreach ($products->random(min(15, $products->count())) as $product) {
            $reviewCount = rand(1, 5);
            for ($i = 0; $i < $reviewCount; $i++) {
                $customer = $customers->random();
                Review::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'customer_id' => $customer->id,
                    ],
                    [
                        'order_id' => Order::inRandomOrder()->first()->id ?? null,
                        'rating' => rand(1, 5),
                        'title' => 'Sample Review',
                        'comment' => 'This is a sample review.',
                        'is_verified_purchase' => true,
                        'is_approved' => true,
                    ]
                );
            }
        }

        // Create some featured reviews
        for ($i = 0; $i < 3; $i++) {
            $customer = $customers->random();
            $product = $products->random();
            Review::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'customer_id' => $customer->id,
                ],
                [
                    'order_id' => Order::inRandomOrder()->first()->id ?? null,
                    'rating' => rand(4, 5),
                    'title' => 'Featured Review',
                    'comment' => 'This is a featured review.',
                    'is_verified_purchase' => true,
                    'is_approved' => true,
                    'is_featured' => true,
                ]
            );
        }
    }

    /**
     * Create wishlist items for customers.
     */
    private function createWishlists(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        // Create wishlist items for random customers
        foreach ($customers->random(min(10, $customers->count())) as $customer) {
            $wishlistCount = rand(2, 6);
            $randomProducts = $products->random(min($wishlistCount, $products->count()));

            foreach ($randomProducts as $product) {
                Wishlist::factory()->create([
                    'customer_id' => $customer->id,
                    'user_id' => $customer->user_id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }

    /**
     * Create cart items for testing.
     */
    private function createCartItems(): void
    {
        $users = User::all();
        $products = Product::all();

        // Create cart items for random users
        foreach ($users->random(min(8, $users->count())) as $user) {
            $cartCount = rand(1, 4);
            $randomProducts = $products->random(min($cartCount, $products->count()));

            foreach ($randomProducts as $product) {
                Cart::factory()->create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
            }
        }

        // Create some guest cart items
        Cart::factory(5)->guest()->create([
            'product_id' => $products->random()->id,
        ]);
    }
}
