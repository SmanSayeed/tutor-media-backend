<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        // Recalculate total_price for all items to ensure accuracy
        $needsRefresh = false;
        foreach ($cartItems as $item) {
            $correctTotal = (float)bcmul((string)$item->unit_price, (string)$item->quantity, 2);
            if (abs((float)$item->total_price - $correctTotal) > 0.01) { // Use tolerance for float comparison
                $item->total_price = $correctTotal;
                $item->save();
                $needsRefresh = true;
            }
        }
        
        // Refresh cart items if any were updated
        if ($needsRefresh) {
            $cartItems = $this->getCartItems();
        }
        
        // Use bcadd for precise decimal arithmetic to avoid floating point precision issues
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return bcadd($carry, (string)$item->total_price, 2);
        }, '0');
        $cartCount = $cartItems->sum('quantity');

        return view('frontend.cart.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1|max:100',
            'buy_now' => 'nullable|boolean',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            $variant = null;
            // Use current_price which respects sale dates
            $unitPrice = $product->current_price;

            // If variant is specified, get variant details
            if ($request->variant_id) {
                $variant = ProductVariant::findOrFail($request->variant_id);
                // Variant inherits product pricing
                $unitPrice = $product->current_price;
            }

            // Get or create session ID for guest users
            $sessionId = $this->getSessionId();

            // If this is a buy_now request, clear existing cart items
            if ($request->buy_now) {
                if (Auth::check()) {
                    Cart::where('user_id', Auth::id())->delete();
                } else {
                    Cart::where('session_id', $sessionId)->delete();
                }
            }

            // Check if item already exists in cart
            $existingCartItem = $this->getCartItem($product->id, $request->variant_id, $sessionId);

            if ($existingCartItem) {
                // Update quantity
                $existingCartItem->updateQuantity($existingCartItem->quantity + $request->quantity);
                $message = $request->buy_now ? 'Preparing your order...' : 'Cart updated successfully!';
            } else {
                // Create new cart item
                $attributes = [];
                if ($variant) {
                    $attributes = [
                        'color' => $variant->color ? $variant->color->name : null,
                        'size' => $variant->size ? $variant->size->name : null,
                        'variant_name' => $variant->name,
                    ];
                }

                // Ensure unit_price and quantity are strings for bcmul
                $totalPrice = bcmul((string)$unitPrice, (string)$request->quantity, 2);
                
                Cart::create([
                    'user_id' => Auth::id(),
                    'session_id' => !Auth::check() ? $sessionId : null,
                    'product_id' => $product->id,
                    'product_variant_id' => $request->variant_id,
                    'quantity' => $request->quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => (float)$totalPrice, // Convert to float for database storage
                    'product_attributes' => $attributes,
                    'is_buy_now' => $request->buy_now ?? false,
                ]);

                $message = $request->buy_now ? 'Preparing your order...' : 'Product added to cart successfully!';
            }

            $cartCount = $this->getCartItems()->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartId): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        try {
            $cartItem = $this->getUserCartItem($cartId);
            \Log::info('Cart update - cartId: ' . $cartId . ', requested quantity: ' . $request->quantity . ', current quantity: ' . $cartItem->quantity . ', unit_price: ' . $cartItem->unit_price);
            $cartItem->updateQuantity($request->quantity);

            // Use bcadd for precise decimal arithmetic
            $cartItems = $this->getCartItems();
            $cartTotal = $cartItems->reduce(function ($carry, $item) {
                return bcadd($carry, (string)$item->total_price, 2);
            }, '0');
            $cartCount = $cartItems->sum('quantity');
            \Log::info('Cart update - new item total_price: ' . $cartItem->total_price . ', cart total: ' . $cartTotal . ', cart count: ' . $cartCount);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_total' => number_format((float)$cartTotal, 2, '.', ''),
                'item_total' => number_format((float)$cartItem->total_price, 2, '.', ''),
                'cart_count' => $cartCount,
            ]);

        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($cartId): JsonResponse
    {
        try {
            $cartItem = $this->getUserCartItem($cartId);
            $cartItem->delete();

            $cartItems = $this->getCartItems();
            // Use bcadd for precise decimal arithmetic
            $cartTotal = $cartItems->reduce(function ($carry, $item) {
                return bcadd($carry, (string)$item->total_price, 2);
            }, '0');
            $cartCount = $cartItems->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully!',
                'cart_total' => number_format((float)$cartTotal, 2, '.', ''),
                'cart_count' => $cartCount,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cart count for header display
     */
    public function getCartCount(): JsonResponse
    {
        $cartCount = $this->getCartItems()->sum('quantity');

        return response()->json([
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear(): JsonResponse
    {
        try {
            $this->getCartItems()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cart items for current user/session
     */
    private function getCartItems()
    {
        $query = Cart::with(['product', 'variant'])
            ->where('is_active', true);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $sessionId = $this->getSessionId();
            if ($sessionId) {
                $query->where('session_id', $sessionId);
            } else {
                // Return empty collection if no session
                return collect();
            }
        }

        return $query->get();
    }

    /**
     * Get specific cart item
     */
    private function getCartItem($productId, $variantId, $sessionId)
    {
        $query = Cart::where('product_id', $productId)
            ->where('is_active', true);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            if ($sessionId) {
                $query->where('session_id', $sessionId);
            } else {
                return null;
            }
        }

        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        } else {
            $query->whereNull('product_variant_id');
        }

        return $query->first();
    }

    /**
     * Get cart item by ID for authenticated user
     */
    private function getUserCartItem($cartId)
    {
        $cartItem = Cart::findOrFail($cartId);

        // Ensure the cart item belongs to the current user
        if (Auth::check() && $cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to cart item');
        }

        if (!Auth::check() && $cartItem->session_id !== $this->getSessionId()) {
            abort(403, 'Unauthorized access to cart item');
        }

        return $cartItem;
    }

    /**
     * Get or generate session ID for guest users
     */
    private function getSessionId()
    {
        if (!Auth::check()) {
            $sessionId = session('cart_session_id');
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                session(['cart_session_id' => $sessionId]);
            }
            return $sessionId;
        }
        return null;
    }
}
