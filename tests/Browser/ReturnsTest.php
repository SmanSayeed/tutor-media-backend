<?php

namespace Tests\Browser;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ReturnRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReturnsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test initiating a return request by a customer.
     * Verifies that customer can create a return request with valid data,
     * form submission works, UI elements are correct, and database is updated.
     *
     * @return void
     */
    public function testInitiateReturn()
    {
        // Create test customer, order, and product
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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

        $orderItem = $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ]);

        $this->browse(function (Browser $browser) use ($user, $order, $orderItem) {
            // Login as customer
            $browser->loginAs($user)
                    ->visit('/orders/' . $order->id)
                    ->assertSee('Return Item')
                    ->clickLink('Return Item');

            // Verify return form is displayed
            $browser->assertPathIs('/returns/create')
                    ->assertSee('Create Return Request')
                    ->assertSee('Order Number')
                    ->assertSee('Return Reason')
                    ->assertSee('Description')
                    ->assertSee($order->order_number)
                    ->assertSee($orderItem->product_name);

            // Fill return form
            $browser->select('#reason', 'defective')
                    ->type('#description', 'Product arrived damaged')
                    ->type('#quantity', '1')
                    ->press('Submit Return Request')
                    ->waitForText('Return request submitted successfully')
                    ->assertSee('Return request submitted successfully');

            // Verify redirect to order details or returns page
            $browser->assertPathIs('/orders/' . $order->id)
                    ->assertSee('Return request submitted');

            // Verify database state
            $this->assertDatabaseHas('return_requests', [
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'status' => 'pending',
                'reason' => 'defective',
                'description' => 'Product arrived damaged',
            ]);

            // Verify return number is generated
            $returnRequest = ReturnRequest::where('order_id', $order->id)->first();
            $this->assertStringStartsWith('RET-', $returnRequest->return_number);
        });
    }

    /**
     * Test admin viewing return requests in the admin panel.
     * Verifies that admin can access returns list, view details,
     * and see all necessary information for each return request.
     *
     * @return void
     */
    public function testAdminViewReturns()
    {
        // Create admin user and return request
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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

        $returnRequest = ReturnRequest::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'return_number' => 'RET-12345',
            'status' => 'pending',
            'reason' => 'defective',
            'description' => 'Product is damaged',
            'items' => json_encode([
                ['product_id' => $product->id, 'quantity' => 1]
            ]),
            'refund_amount' => 100.00,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $returnRequest, $order, $customer) {
            // Login as admin and visit returns page
            $browser->loginAs($admin)
                    ->visit('/admin/returns')
                    ->assertSee('Return Requests')
                    ->assertSee($returnRequest->return_number)
                    ->assertSee($order->order_number)
                    ->assertSee($customer->name ?? $customer->email)
                    ->assertSee('Pending')
                    ->assertSee('Defective');

            // Click on return to view details
            $browser->clickLink($returnRequest->return_number)
                    ->assertPathIs('/admin/returns/' . $returnRequest->id)
                    ->assertSee('Return Request Details')
                    ->assertSee($returnRequest->return_number)
                    ->assertSee($order->order_number)
                    ->assertSee('Defective')
                    ->assertSee('Product is damaged')
                    ->assertSee('৳100.00')
                    ->assertSee('Pending');

            // Verify action buttons are present
            $browser->assertSee('Approve')
                    ->assertSee('Reject')
                    ->assertSee('Update Status');
        });
    }

    /**
     * Test admin approving a return request.
     * Verifies that admin can approve returns, status updates correctly,
     * approval timestamp is set, and UI reflects the changes.
     *
     * @return void
     */
    public function testAdminApproveReturn()
    {
        // Create admin user and pending return request
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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

        $returnRequest = ReturnRequest::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'return_number' => 'RET-12345',
            'status' => 'pending',
            'reason' => 'defective',
            'description' => 'Product is damaged',
            'items' => json_encode([
                ['product_id' => $product->id, 'quantity' => 1]
            ]),
            'refund_amount' => 100.00,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $returnRequest) {
            // Login as admin and visit return details
            $browser->loginAs($admin)
                    ->visit('/admin/returns/' . $returnRequest->id)
                    ->assertSee('Return Request Details')
                    ->assertSee('Pending');

            // Approve the return
            $browser->press('Approve')
                    ->waitForText('Return request approved successfully')
                    ->assertSee('Return request approved successfully')
                    ->assertSee('Approved');

            // Verify database state
            $this->assertDatabaseHas('return_requests', [
                'id' => $returnRequest->id,
                'status' => 'approved',
            ]);

            // Verify approved_at timestamp is set
            $updatedReturn = ReturnRequest::find($returnRequest->id);
            $this->assertNotNull($updatedReturn->approved_at);
        });
    }

    /**
     * Test admin rejecting a return request.
     * Verifies that admin can reject returns with notes,
     * status updates to rejected, and rejection is properly recorded.
     *
     * @return void
     */
    public function testAdminRejectReturn()
    {
        // Create admin user and pending return request
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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

        $returnRequest = ReturnRequest::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'return_number' => 'RET-12345',
            'status' => 'pending',
            'reason' => 'defective',
            'description' => 'Product is damaged',
            'items' => json_encode([
                ['product_id' => $product->id, 'quantity' => 1]
            ]),
            'refund_amount' => 100.00,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $returnRequest) {
            // Login as admin and visit return details
            $browser->loginAs($admin)
                    ->visit('/admin/returns/' . $returnRequest->id)
                    ->assertSee('Return Request Details')
                    ->assertSee('Pending');

            // Reject the return with notes
            $browser->press('Reject')
                    ->whenAvailable('#rejection-modal', function ($modal) {
                        $modal->type('#admin_notes', 'Item shows signs of wear, not defective')
                              ->press('Confirm Rejection');
                    })
                    ->waitForText('Return request rejected')
                    ->assertSee('Return request rejected')
                    ->assertSee('Rejected');

            // Verify database state
            $this->assertDatabaseHas('return_requests', [
                'id' => $returnRequest->id,
                'status' => 'rejected',
                'admin_notes' => 'Item shows signs of wear, not defective',
            ]);
        });
    }

    /**
     * Test return status updates through different stages.
     * Verifies that return status can be updated from pending to approved,
     * approved to processing, processing to completed, and proper timestamps.
     *
     * @return void
     */
    public function testReturnStatusUpdates()
    {
        // Create admin user and approved return request
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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

        $returnRequest = ReturnRequest::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'return_number' => 'RET-12345',
            'status' => 'approved',
            'reason' => 'defective',
            'description' => 'Product is damaged',
            'items' => json_encode([
                ['product_id' => $product->id, 'quantity' => 1]
            ]),
            'refund_amount' => 100.00,
            'approved_at' => now(),
        ]);

        $this->browse(function (Browser $browser) use ($admin, $returnRequest) {
            // Login as admin and visit return details
            $browser->loginAs($admin)
                    ->visit('/admin/returns/' . $returnRequest->id)
                    ->assertSee('Approved');

            // Update status to processing
            $browser->select('#status', 'processing')
                    ->press('Update Status')
                    ->waitForText('Status updated successfully')
                    ->assertSee('Status updated successfully')
                    ->assertSee('Processing');

            // Verify database state
            $this->assertDatabaseHas('return_requests', [
                'id' => $returnRequest->id,
                'status' => 'processing',
            ]);

            // Update to completed
            $browser->select('#status', 'completed')
                    ->press('Update Status')
                    ->waitForText('Status updated successfully')
                    ->assertSee('Completed');

            // Verify database state and timestamps
            $this->assertDatabaseHas('return_requests', [
                'id' => $returnRequest->id,
                'status' => 'completed',
            ]);

            $updatedReturn = ReturnRequest::find($returnRequest->id);
            $this->assertNotNull($updatedReturn->processed_at);
            $this->assertNotNull($updatedReturn->completed_at);
        });
    }

    /**
     * Test return form validation.
     * Verifies that validation errors are displayed for required fields,
     * invalid data is rejected, and proper error messages are shown.
     *
     * @return void
     */
    public function testReturnFormValidation()
    {
        // Create test customer and order
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 100.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 110.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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

        $this->browse(function (Browser $browser) use ($user, $order) {
            // Login as customer and visit return form
            $browser->loginAs($user)
                    ->visit('/returns/create?order=' . $order->id)
                    ->assertSee('Create Return Request');

            // Try to submit empty form
            $browser->press('Submit Return Request')
                    ->waitForText('The reason field is required')
                    ->assertSee('The reason field is required')
                    ->assertSee('The description field is required');

            // Test invalid quantity
            $browser->select('#reason', 'defective')
                    ->type('#description', 'Test description')
                    ->type('#quantity', '0')
                    ->press('Submit Return Request')
                    ->assertSee('The quantity must be at least 1');

            // Test quantity exceeding order quantity
            $browser->type('#quantity', '5')
                    ->press('Submit Return Request')
                    ->assertSee('The quantity cannot exceed the ordered quantity');

            // Test description length validation
            $browser->type('#description', str_repeat('a', 1001))
                    ->type('#quantity', '1')
                    ->press('Submit Return Request')
                    ->assertSee('The description may not be greater than 1000 characters');
        });
    }

    /**
     * Test return creation with invalid data.
     * Verifies that system handles edge cases and invalid inputs gracefully,
     * prevents duplicate returns, and maintains data integrity.
     *
     * @return void
     */
    public function testReturnWithInvalidData()
    {
        // Create test customer and order
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
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
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'pending', // Order not delivered yet
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

        $this->browse(function (Browser $browser) use ($user, $order) {
            // Try to create return for undelivered order
            $browser->loginAs($user)
                    ->visit('/returns/create?order=' . $order->id)
                    ->assertSee('Create Return Request')
                    ->select('#reason', 'defective')
                    ->type('#description', 'Test description')
                    ->type('#quantity', '1')
                    ->press('Submit Return Request')
                    ->waitForText('Returns are only allowed for delivered orders')
                    ->assertSee('Returns are only allowed for delivered orders');

            // Verify no return was created
            $this->assertDatabaseMissing('return_requests', [
                'order_id' => $order->id,
            ]);
        });
    }

    /**
     * Test return creation for non-existent order.
     * Verifies that system handles invalid order IDs gracefully,
     * shows appropriate error messages, and doesn't crash.
     *
     * @return void
     */
    public function testReturnForNonExistentOrder()
    {
        // Create test customer
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            // Try to create return for non-existent order
            $browser->loginAs($user)
                    ->visit('/returns/create?order=99999')
                    ->assertSee('Order not found')
                    ->assertDontSee('Create Return Request');

            // Verify no return was created
            $this->assertDatabaseMissing('return_requests', [
                'order_id' => 99999,
            ]);
        });
    }

    /**
     * Test multiple return requests for the same order.
     * Verifies that multiple returns can be created for the same order,
     * each with unique return numbers, and proper tracking.
     *
     * @return void
     */
    public function testMultipleReturnsForSameOrder()
    {
        // Create test customer, order, and multiple products
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $category = \App\Models\Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product1 = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 100.00,
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $product2 = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product 2',
            'slug' => 'test-product-2',
            'price' => 150.00,
            'is_active' => true,
            'stock_quantity' => 5,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'status' => 'delivered',
            'subtotal' => 250.00,
            'tax_amount' => 0.00,
            'shipping_amount' => 10.00,
            'total_amount' => 260.00,
            'currency' => 'BDT',
            'payment_status' => 'paid',
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
            'product_id' => $product1->id,
            'product_name' => $product1->name,
            'quantity' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ]);

        $order->items()->create([
            'product_id' => $product2->id,
            'product_name' => $product2->name,
            'quantity' => 1,
            'unit_price' => 150.00,
            'total_price' => 150.00,
        ]);

        $this->browse(function (Browser $browser) use ($user, $order, $product1, $product2) {
            // Login as customer
            $browser->loginAs($user);

            // Create first return request
            $browser->visit('/returns/create?order=' . $order->id)
                    ->select('#reason', 'defective')
                    ->type('#description', 'First product is damaged')
                    ->type('#quantity', '1')
                    ->press('Submit Return Request')
                    ->waitForText('Return request submitted successfully');

            // Create second return request for different product
            $browser->visit('/returns/create?order=' . $order->id)
                    ->select('#reason', 'wrong_item')
                    ->type('#description', 'Received wrong product')
                    ->type('#quantity', '1')
                    ->press('Submit Return Request')
                    ->waitForText('Return request submitted successfully');

            // Verify database state - two returns created
            $returns = ReturnRequest::where('order_id', $order->id)->get();
            $this->assertCount(2, $returns);

            // Verify return numbers are unique
            $returnNumbers = $returns->pluck('return_number')->toArray();
            $this->assertCount(2, array_unique($returnNumbers));

            // Verify both returns have different reasons
            $this->assertEquals('defective', $returns[0]->reason);
            $this->assertEquals('wrong_item', $returns[1]->reason);

            // Verify both are pending
            $this->assertEquals('pending', $returns[0]->status);
            $this->assertEquals('pending', $returns[1]->status);
        });
    }
}