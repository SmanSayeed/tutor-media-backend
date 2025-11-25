<?php
// Script to add a cart item for testing checkout
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Str;

$p = Product::first();
if (! $p) {
    echo "No products found. Seed or create products first.\n";
    exit(1);
}

$cart = Cart::create([
    'user_id' => null,
    'session_id' => Str::uuid()->toString(),
    'product_id' => $p->id,
    'product_variant_id' => null,
    'quantity' => 1,
    'unit_price' => $p->current_price,
    'total_price' => $p->current_price,
    'product_attributes' => [],
]);

echo "Created cart item with id: {$cart->id}, product_id: {$p->id}\n";
