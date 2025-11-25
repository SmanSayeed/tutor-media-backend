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

class AdminCrudTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test creating a new product through admin panel.
     * Verifies that product is created successfully with all required fields,
     * UI elements are displayed correctly, and database state is updated.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        // Create admin user
        $admin = User::factory()->create(['is_admin' => true]);

        // Create test category
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $category) {
            // Login as admin
            $browser->loginAs($admin)
                    ->visit(route('admin.products.create'))
                    ->assertSee('Create Product')
                    ->assertSee('Product Name')
                    ->assertSee('Category')
                    ->assertSee('Price');

            // Fill product creation form
            $browser->type('#name', 'Test Product')
                    ->select('#category_id', $category->id)
                    ->type('#price', '100.00')
                    ->type('#description', 'Test product description')
                    ->type('#stock_quantity', '10')
                    ->check('#is_active')
                    ->press('Create Product')
                    ->waitForText('Product created successfully')
                    ->assertSee('Product created successfully');

            // Verify redirect to product list
            $browser->assertPathIs('/admin/products')
                    ->assertSee('Test Product')
                    ->assertSee('৳100.00');

            // Verify database state
            $this->assertDatabaseHas('products', [
                'name' => 'Test Product',
                'category_id' => $category->id,
                'price' => 100.00,
                'description' => 'Test product description',
                'stock_quantity' => 10,
                'is_active' => true,
            ]);
        });
    }

    /**
     * Test reading/viewing product details in admin panel.
     * Verifies that product information is displayed correctly,
     * all fields are populated, and navigation works properly.
     *
     * @return void
     */
    public function testReadProduct()
    {
        // Create admin user and test product
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Test product description',
            'price' => 100.00,
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $product) {
            // Login as admin and visit product list
            $browser->loginAs($admin)
                    ->visit(route('admin.products.index'))
                    ->assertSee('Products')
                    ->assertSee($product->name)
                    ->assertSee('৳100.00');

            // Click on product to view details
            $browser->clickLink($product->name)
                    ->assertPathIs('/admin/products/' . $product->id)
                    ->assertSee('Product Details')
                    ->assertSee($product->name)
                    ->assertSee($product->description)
                    ->assertSee('৳100.00')
                    ->assertSee('10') // Stock quantity
                    ->assertSee('Active'); // Status
        });
    }

    /**
     * Test updating an existing product through admin panel.
     * Verifies that product information is updated correctly,
     * form pre-population works, and database is updated.
     *
     * @return void
     */
    public function testUpdateProduct()
    {
        // Create admin user and test product
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Original Product',
            'slug' => 'original-product',
            'description' => 'Original description',
            'price' => 100.00,
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $product) {
            // Login as admin and visit product edit page
            $browser->loginAs($admin)
                    ->visit(route('admin.products.edit', $product))
                    ->assertSee('Edit Product')
                    ->assertInputValue('#name', 'Original Product')
                    ->assertInputValue('#price', '100.00')
                    ->assertInputValue('#description', 'Original description');

            // Update product information
            $browser->type('#name', 'Updated Product')
                    ->type('#price', '150.00')
                    ->type('#description', 'Updated description')
                    ->type('#stock_quantity', '15')
                    ->press('Update Product')
                    ->waitForText('Product updated successfully')
                    ->assertSee('Product updated successfully');

            // Verify redirect and updated information
            $browser->assertPathIs('/admin/products')
                    ->assertSee('Updated Product')
                    ->assertSee('৳150.00');

            // Verify database state
            $this->assertDatabaseHas('products', [
                'id' => $product->id,
                'name' => 'Updated Product',
                'price' => 150.00,
                'description' => 'Updated description',
                'stock_quantity' => 15,
            ]);
        });
    }

    /**
     * Test deleting a product through admin panel.
     * Verifies that product is removed from database,
     * confirmation dialog appears, and UI updates correctly.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        // Create admin user and test product
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Product to Delete',
            'slug' => 'product-to-delete',
            'description' => 'This product will be deleted',
            'price' => 100.00,
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $product) {
            // Login as admin and visit product list
            $browser->loginAs($admin)
                    ->visit(route('admin.products.index'))
                    ->assertSee('Products')
                    ->assertSee($product->name);

            // Click delete button and confirm
            $browser->press('#delete-product-' . $product->id)
                    ->acceptDialog()
                    ->waitForText('Product deleted successfully')
                    ->assertSee('Product deleted successfully');

            // Verify product is removed from list
            $browser->assertDontSee($product->name);

            // Verify database state
            $this->assertDatabaseMissing('products', [
                'id' => $product->id,
                'name' => 'Product to Delete',
            ]);
        });
    }

    /**
     * Test creating a new user through admin panel.
     * Verifies user creation with proper role assignment,
     * form validation, and database persistence.
     *
     * @return void
     */
    public function testCreateUser()
    {
        // Create admin user
        $admin = User::factory()->create(['is_admin' => true]);

        $this->browse(function (Browser $browser) use ($admin) {
            // Login as admin and visit user creation page
            $browser->loginAs($admin)
                    ->visit(route('admin.users.create'))
                    ->assertSee('Create User')
                    ->assertSee('Name')
                    ->assertSee('Email')
                    ->assertSee('Password');

            // Fill user creation form
            $browser->type('#name', 'Test User')
                    ->type('#email', 'testuser@example.com')
                    ->type('#password', 'password123')
                    ->type('#password_confirmation', 'password123')
                    ->check('#is_admin') // Make admin user
                    ->press('Create User')
                    ->waitForText('User created successfully')
                    ->assertSee('User created successfully');

            // Verify redirect to user list
            $browser->assertPathIs('/admin/users')
                    ->assertSee('Test User')
                    ->assertSee('testuser@example.com');

            // Verify database state
            $this->assertDatabaseHas('users', [
                'name' => 'Test User',
                'email' => 'testuser@example.com',
                'is_admin' => true,
            ]);
        });
    }

    /**
     * Test reading/viewing user details in admin panel.
     * Verifies user information display, role indicators,
     * and profile data presentation.
     *
     * @return void
     */
    public function testReadUser()
    {
        // Create admin user and test user
        $admin = User::factory()->create(['is_admin' => true]);
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'is_admin' => false,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $testUser) {
            // Login as admin and visit user list
            $browser->loginAs($admin)
                    ->visit(route('admin.users'))
                    ->assertSee('Users')
                    ->assertSee($testUser->name)
                    ->assertSee($testUser->email);

            // Click on user to view details
            $browser->clickLink($testUser->name)
                    ->assertPathIs('/admin/user/' . $testUser->id)
                    ->assertSee('User Details')
                    ->assertSee($testUser->name)
                    ->assertSee($testUser->email)
                    ->assertSee('Customer'); // Role indicator
        });
    }

    /**
     * Test updating user information through admin panel.
     * Verifies form pre-population, update functionality,
     * and role/permission changes.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        // Create admin user and test user
        $admin = User::factory()->create(['is_admin' => true]);
        $testUser = User::factory()->create([
            'name' => 'Original User',
            'email' => 'original@example.com',
            'is_admin' => false,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $testUser) {
            // Login as admin and visit user edit page
            $browser->loginAs($admin)
                    ->visit(route('admin.users.edit', $testUser))
                    ->assertSee('Edit User')
                    ->assertInputValue('#name', 'Original User')
                    ->assertInputValue('#email', 'original@example.com');

            // Update user information
            $browser->type('#name', 'Updated User')
                    ->type('#email', 'updated@example.com')
                    ->check('#is_admin') // Promote to admin
                    ->press('Update User')
                    ->waitForText('User updated successfully')
                    ->assertSee('User updated successfully');

            // Verify redirect and updated information
            $browser->assertPathIs('/admin/users')
                    ->assertSee('Updated User')
                    ->assertSee('updated@example.com');

            // Verify database state
            $this->assertDatabaseHas('users', [
                'id' => $testUser->id,
                'name' => 'Updated User',
                'email' => 'updated@example.com',
                'is_admin' => true,
            ]);
        });
    }

    /**
     * Test deleting a user through admin panel.
     * Verifies user removal, confirmation dialogs,
     * and proper cleanup of related data.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        // Create admin user and test user
        $admin = User::factory()->create(['is_admin' => true]);
        $testUser = User::factory()->create([
            'name' => 'User to Delete',
            'email' => 'delete@example.com',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $testUser) {
            // Login as admin and visit user list
            $browser->loginAs($admin)
                    ->visit(route('admin.users'))
                    ->assertSee('Users')
                    ->assertSee($testUser->name);

            // Click delete button and confirm
            $browser->press('#delete-user-' . $testUser->id)
                    ->acceptDialog()
                    ->waitForText('User deleted successfully')
                    ->assertSee('User deleted successfully');

            // Verify user is removed from list
            $browser->assertDontSee($testUser->name);

            // Verify database state
            $this->assertDatabaseMissing('users', [
                'id' => $testUser->id,
                'name' => 'User to Delete',
            ]);
        });
    }

    /**
     * Test viewing and updating order status through admin panel.
     * Verifies order management functionality, status changes,
     * and proper UI updates.
     *
     * @return void
     */
    public function testManageOrder()
    {
        // Create admin user, customer, and order
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create();
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 100.00,
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'status' => 'pending',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'pending',
            'payment_method' => 'cash_on_delivery',
            'billing_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
            ],
            'shipping_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
            ],
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $order, $customer, $product) {
            // Login as admin and visit orders page
            $browser->loginAs($admin)
                    ->visit(route('admin.orders.index'))
                    ->assertSee('Orders')
                    ->assertSee($order->order_number)
                    ->assertSee($customer->name)
                    ->assertSee('Pending');

            // Click on order to view details
            $browser->clickLink($order->order_number)
                    ->assertPathIs('/admin/orders/' . $order->id)
                    ->assertSee('Order Details')
                    ->assertSee($order->order_number)
                    ->assertSee($customer->name)
                    ->assertSee($product->name)
                    ->assertSee('৳110.00')
                    ->assertSee('Pending');

            // Update order status
            $browser->select('#status', 'processing')
                    ->press('Update Status')
                    ->waitForText('Order status updated successfully')
                    ->assertSee('Order status updated successfully')
                    ->assertSee('Processing');

            // Verify database state
            $this->assertDatabaseHas('orders', [
                'id' => $order->id,
                'status' => 'processing',
            ]);
        });
    }

    /**
     * Test product creation with validation errors.
     * Verifies that form validation works correctly,
     * error messages are displayed, and invalid data is rejected.
     *
     * @return void
     */
    public function testCreateProductValidation()
    {
        // Create admin user
        $admin = User::factory()->create(['is_admin' => true]);

        $this->browse(function (Browser $browser) use ($admin) {
            // Login as admin and visit product creation page
            $browser->loginAs($admin)
                    ->visit(route('admin.products.create'))
                    ->assertSee('Create Product');

            // Try to submit empty form
            $browser->press('Create Product')
                    ->waitForText('The name field is required')
                    ->assertSee('The name field is required')
                    ->assertSee('The category id field is required')
                    ->assertSee('The price field is required');

            // Fill partial data and test specific validations
            $browser->type('#name', 'Test Product')
                    ->type('#price', 'invalid-price')
                    ->press('Create Product')
                    ->assertSee('The price must be a number');

            // Test negative price
            $browser->type('#price', '-100')
                    ->press('Create Product')
                    ->assertSee('The price must be at least 0');

            // Test stock quantity validation
            $browser->type('#stock_quantity', '-5')
                    ->press('Create Product')
                    ->assertSee('The stock quantity must be at least 0');
        });
    }

    /**
     * Test bulk operations on products.
     * Verifies bulk delete functionality and proper confirmation dialogs.
     *
     * @return void
     */
    public function testBulkDeleteProducts()
    {
        // Create admin user and multiple products
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $products = [];
        for ($i = 1; $i <= 3; $i++) {
            $products[] = Product::create([
                'category_id' => $category->id,
                'name' => "Bulk Product {$i}",
                'slug' => "bulk-product-{$i}",
                'price' => 100.00 * $i,
                'is_active' => true,
                'stock_quantity' => 10,
            ]);
        }

        $this->browse(function (Browser $browser) use ($admin, $products) {
            // Login as admin and visit products page
            $browser->loginAs($admin)
                    ->visit(route('admin.products.index'))
                    ->assertSee('Products');

            // Select multiple products for bulk delete
            foreach ($products as $product) {
                $browser->check('#product-' . $product->id);
            }

            // Click bulk delete button and confirm
            $browser->press('#bulk-delete-btn')
                    ->acceptDialog()
                    ->waitForText('Products deleted successfully')
                    ->assertSee('Products deleted successfully');

            // Verify products are removed from list
            foreach ($products as $product) {
                $browser->assertDontSee($product->name);
            }

            // Verify database state
            foreach ($products as $product) {
                $this->assertDatabaseMissing('products', [
                    'id' => $product->id,
                ]);
            }
        });
    }

    /**
     * Test admin access control.
     * Verifies that non-admin users cannot access admin panel,
     * and proper redirects occur.
     *
     * @return void
     */
    public function testAdminAccessControl()
    {
        // Create regular user (non-admin)
        $regularUser = User::factory()->create(['is_admin' => false]);

        $this->browse(function (Browser $browser) use ($regularUser) {
            // Try to access admin panel as regular user
            $browser->loginAs($regularUser)
                    ->visit('/admin')
                    ->assertPathIs('/login') // Should redirect to login
                    ->assertSee('Login'); // Or appropriate access denied message
        });
    }

    /**
     * Test category CRUD operations.
     * Verifies creating, reading, updating, and deleting categories
     * through the admin panel.
     *
     * @return void
     */
    public function testCategoryCrud()
    {
        // Create admin user
        $admin = User::factory()->create(['is_admin' => true]);

        $this->browse(function (Browser $browser) use ($admin) {
            // Login as admin and visit categories page
            $browser->loginAs($admin)
                    ->visit(route('admin.categories.index'))
                    ->assertSee('Categories')
                    ->assertSee('Create Category');

            // Create new category
            $browser->clickLink('Create Category')
                    ->assertPathIs('/admin/categories/create')
                    ->type('#name', 'Test Category')
                    ->check('#is_active')
                    ->press('Create Category')
                    ->waitForText('Category created successfully')
                    ->assertSee('Category created successfully')
                    ->assertSee('Test Category');

            // Verify database state
            $this->assertDatabaseHas('categories', [
                'name' => 'Test Category',
                'is_active' => true,
            ]);

            // Get the created category for further testing
            $category = Category::where('name', 'Test Category')->first();

            // Update category
            $browser->visit(route('admin.categories.edit', $category))
                    ->type('#name', 'Updated Category')
                    ->press('Update Category')
                    ->waitForText('Category updated successfully')
                    ->assertSee('Category updated successfully')
                    ->assertSee('Updated Category');

            // Verify database update
            $this->assertDatabaseHas('categories', [
                'id' => $category->id,
                'name' => 'Updated Category',
            ]);

            // Delete category
            $browser->visit(route('admin.categories.index'))
                    ->press('#delete-category-' . $category->id)
                    ->acceptDialog()
                    ->waitForText('Category deleted successfully')
                    ->assertSee('Category deleted successfully')
                    ->assertDontSee('Updated Category');

            // Verify database deletion
            $this->assertDatabaseMissing('categories', [
                'id' => $category->id,
            ]);
        });
    }
}