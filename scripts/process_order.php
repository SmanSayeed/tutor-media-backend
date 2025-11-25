<?php
// Script to call CheckoutController::process directly for testing (bypasses HTTP middleware/CSRF)
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// Find an active cart entry to use
$cart = Cart::where('is_active', true)->first();
if (! $cart) {
    echo "No active cart items found. Add to cart first via UI or script.\n";
    exit(1);
}

$sessionId = $cart->session_id;
$cartItems = Cart::where('is_active', true)->where('session_id', $sessionId)->with(['product', 'variant'])->get();

if ($cartItems->isEmpty()) {
    echo "No cart items for session: {$sessionId}\n";
    exit(1);
}

// Prepare shipping data for test
$shipping = [
    'name' => 'Test User',
    'phone' => '0123456789',
    'email' => 'test@example.com',
    'address' => '123 Test St',
    'city' => 'Test City',
    'postal_code' => '1000',
];

DB::beginTransaction();
try {
    $subtotal = $cartItems->sum('total_price');
    $taxAmount = 0; // No tax
    $shippingAmount = $subtotal > 1000 ? 0 : 100;
    $totalAmount = $subtotal + $taxAmount + $shippingAmount;

    $order = Order::create([
        'user_id' => null,
        'status' => 'pending',
        'subtotal' => $subtotal,
        'tax_amount' => $taxAmount,
        'shipping_amount' => $shippingAmount,
        'total_amount' => $totalAmount,
        'currency' => 'BDT',
        'payment_status' => 'pending',
        'payment_method' => 'cash_on_delivery',
        'billing_address' => $shipping,
        'shipping_address' => $shipping,
        'shipping_method' => 'standard',
        'notes' => 'Test order via script',
    ]);

    foreach ($cartItems as $cartItem) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cartItem->product_id,
            'product_variant_id' => $cartItem->product_variant_id,
            'product_name' => $cartItem->product->name,
            'product_sku' => $cartItem->product->sku,
            'quantity' => $cartItem->quantity,
            'unit_price' => $cartItem->unit_price,
            'total_price' => $cartItem->total_price,
            'product_attributes' => $cartItem->product_attributes,
        ]);

        // update sales and reduce stock
        if ($cartItem->product) {
            $cartItem->product->increment('sales_count', $cartItem->quantity);
        }
        if ($cartItem->variant) {
            $cartItem->variant->decrement('stock_quantity', $cartItem->quantity);
        }

        // mark cart item inactive
        $cartItem->is_active = false;
        $cartItem->save();
    }

    DB::commit();
    echo json_encode(['success' => true, 'order_id' => $order->id, 'order_number' => $order->order_number]) . PHP_EOL;
} catch (\Exception $e) {
    DB::rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]) . PHP_EOL;
}
