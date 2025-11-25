<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AdvancePaymentSetting;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Display checkout page
     */
    public function index()
    {

        $cartItems = $this->getUserCartItems();
        // Use bcadd for precise decimal arithmetic to avoid floating point precision issues
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return bcadd($carry, (string)$item->total_price, 2);
        }, '0');
        $cartCount = $cartItems->sum('quantity');

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $user = Auth::user();

        // If user is not logged in, pass empty user object for guest checkout form
        if (!$user) {
            $user = new \App\Models\User();
        }

        $advancePaymentSettings = AdvancePaymentSetting::current();

        // Get default shipping charge from database
        $defaultShippingCharge = $this->shippingService->getDefaultShippingCharge();

        return view('frontend.checkout.index', compact('cartItems', 'cartTotal', 'cartCount', 'user', 'advancePaymentSettings', 'defaultShippingCharge'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request): JsonResponse
    {
        // Validate guest user information if not logged in

        // Normalize empty email strings to null before validation
        if ($request->has('email') && $request->input('email') === '') {
            $request->merge(['email' => null]);
        }

        if (!Auth::check()) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'nullable|sometimes|email|max:255',
                'phone' => 'required|regex:/^[0-9]+$/|min:10|max:20',
                'address' => 'required|string|max:500',
                'city' => 'nullable|string|max:100',
                'division' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'postal_code' => 'nullable|string|max:20',
            ], [
                'phone.regex' => 'Phone number must contain only numbers.',
                'phone.min' => 'Phone number must be at least 10 digits.',
            ]);
        }

        // Prevent admin users from placing orders
        if (Auth::check() && Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin users are not allowed to place orders.',
            ], 403);
        }

        $request->validate([
            'email' => 'nullable|sometimes|email|max:255',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:20',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'division' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'billing_address' => 'nullable|array',
            'billing_address.name' => 'nullable|string|max:255',
            'billing_address.phone' => 'nullable|regex:/^[0-9]+$/|max:20',
            'billing_address.address' => 'nullable|string|max:500',
            'billing_address.city' => 'nullable|string|max:100',
            'billing_address.postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:cod,cash_on_delivery',
            'notes' => 'nullable|string|max:500',
        ], [
            'phone.regex' => 'Phone number must contain only numbers.',
            'phone.min' => 'Phone number must be at least 10 digits.',
            'billing_address.phone.regex' => 'Billing phone number must contain only numbers.',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cartItems = $this->getUserCartItems();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 400);
            }

            // If user is not logged in, create a guest user record or handle as guest
            if (!$user) {
                // Guest user - get data from request
                $first_name = $request->input('first_name');
                $last_name = $request->input('last_name');
                
                // Validate that first_name and last_name are provided for guests
                if (empty($first_name) || empty($last_name)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'First name and last name are required.',
                    ], 422);
                }
                
                $userData = [
                    'name' => trim($first_name . ' ' . $last_name),
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address') ?? $request->input('shipping_address'),
                    'city' => $request->input('city') ?? $request->input('district'), // Use city if provided, otherwise map district to city
                    'state' => $request->input('division'), // Map division to state
                    'postal_code' => $request->input('postal_code'),
                    'is_guest' => true,
                    'password' => bcrypt(uniqid('guest_', true)), // Generate a random password for guest users
                ];
                
                // Only include email if it's provided and not empty
                $email = $request->input('email');
                if (!empty($email) && trim($email) !== '') {
                    $userData['email'] = trim($email);
                }
                // Check if user with this email exists (only if email is provided)
                $existingUser = null;
                if (!empty($userData['email'])) {
                    $existingUser = \App\Models\User::where('email', $userData['email'])->first();
                }

                // If user doesn't exist, create a new guest user
                if (!$existingUser) {
                    $user = \App\Models\User::create($userData);
                } else {
                    // If user exists, update their details for this order
                    $updateData = [
                        'first_name' => $userData['first_name'],
                        'last_name' => $userData['last_name'],
                        'phone' => $userData['phone'],
                        'address' => $userData['address'],
                        'city' => $userData['city'],
                        'state' => $userData['state'],
                        'postal_code' => $userData['postal_code'],
                    ];
                    
                    // Only update email if provided
                    if (!empty($userData['email'])) {
                        $updateData['email'] = $userData['email'];
                    }
                    
                    $existingUser->update($updateData);
                    $user = $existingUser;
                }
            } else {
                // Logged-in user - update their information from request if provided
                $updateData = [];
                
                // Only update fields that are provided in the request
                if ($request->has('phone') && !empty($request->input('phone'))) {
                    $updateData['phone'] = $request->input('phone');
                }
                if ($request->has('address') && !empty($request->input('address'))) {
                    $updateData['address'] = $request->input('address');
                }
                if ($request->has('city') && !empty($request->input('city'))) {
                    $updateData['city'] = $request->input('city');
                } elseif ($request->has('district') && !empty($request->input('district'))) {
                    $updateData['city'] = $request->input('district');
                }
                if ($request->has('division') && !empty($request->input('division'))) {
                    $updateData['state'] = $request->input('division');
                }
                if ($request->has('postal_code') && !empty($request->input('postal_code'))) {
                    $updateData['postal_code'] = $request->input('postal_code');
                }
                if ($request->has('email') && !empty($request->input('email'))) {
                    $updateData['email'] = $request->input('email');
                }
                
                // Update user if there's data to update
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            }

            // Ensure user exists (should always be true at this point)
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create or retrieve user account.',
                ], 500);
            }

            // Log in guest users for the current session
            if (!$user->id || $user->is_guest) {
                Auth::login($user);
            }

            // Check stock availability - verify sufficient quantity for each item
            foreach ($cartItems as $item) {
                if ($item->variant) {
                    if ($item->variant->stock_quantity < $item->quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => "Insufficient stock for {$item->product->name}. Requested: {$item->quantity}, Available: {$item->variant->stock_quantity}",
                        ], 400);
                    }
                } elseif (!$item->product->isInStock()) {
                    return response()->json([
                        'success' => false,
                        'message' => "{$item->product->name} is out of stock.",
                    ], 400);
                }
            }

            // Calculate totals - Use bcadd for precise decimal arithmetic
            $subtotal = $cartItems->reduce(function ($carry, $item) {
                return bcadd($carry, (string)$item->total_price, 2);
            }, '0');
            $taxAmount = 0; // No tax

            // Calculate shipping using ShippingService
            $shippingAmount = $this->calculateShippingAmount($request, $subtotal);

            $discountAmount = 0;
            $couponCode = null;

            if (session()->has('coupon')) {
                $coupon = session('coupon');
                $discountAmount = $coupon['discount'];
                $couponCode = $coupon['code'];
            }

            $advancePaymentSettings = AdvancePaymentSetting::current();
            $advancePaymentAmount = 0;
            if ($advancePaymentSettings->advance_payment_status) {
                $advancePaymentAmount = $advancePaymentSettings->advance_payment_amount;
            }

            // Use bcadd for precise total calculation
            $totalAmount = bcadd($subtotal, (string)$taxAmount, 2);
            $totalAmount = bcadd($totalAmount, (string)$shippingAmount, 2);
            $totalAmount = bcsub($totalAmount, (string)$discountAmount, 2);

            // Prepare shipping address as array with all fields
            // For logged-in users, use user data; for guests, use request data
            $shippingAddress = [
                'first_name' => $user->first_name ?? $request->input('first_name'),
                'last_name' => $user->last_name ?? $request->input('last_name'),
                'name' => trim(($user->first_name ?? $request->input('first_name') ?? '') . ' ' . ($user->last_name ?? $request->input('last_name') ?? '')),
                'email' => $user->email ?? $request->input('email'),
                'phone' => $user->phone ?? $request->input('phone'),
                'address' => $request->input('address') ?? $request->input('shipping_address') ?? $user->address,
                'city' => $request->input('city') ?? $request->input('district') ?? $user->city,
                'division' => $request->input('division') ?? $user->state,
                'district' => $request->input('district') ?? $user->city,
                'postal_code' => $request->input('postal_code') ?? $user->postal_code,
            ];

            // Prepare billing address - use shipping address as default if not provided
            $billingAddress = $request->input('billing_address');
            if (empty($billingAddress) || !is_array($billingAddress) || empty(array_filter($billingAddress))) {
                // Use shipping address as billing address
                $billingAddress = [
                    'name' => $shippingAddress['name'],
                    'phone' => $shippingAddress['phone'],
                    'address' => $shippingAddress['address'],
                    'city' => $shippingAddress['city'],
                    'postal_code' => $shippingAddress['postal_code'],
                ];
            }

            // Create order - Convert string values from bcadd to float for database storage
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => (float)$subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => (float)$totalAmount,
                'advance_payment_amount' => $advancePaymentAmount,
                'payment_status' => 'pending',
                'payment_method' => $request->input('payment_method'),
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress,
                'notes' => $request->input('notes'),
                'is_guest' => !Auth::check() || $user->is_guest,
            ]);

            // Create order items
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

                // Update product sales count
                $cartItem->product->increment('sales_count', $cartItem->quantity);

                // Reduce stock if variant exists
                if ($cartItem->variant) {
                    $cartItem->variant->decrement('stock_quantity', $cartItem->quantity);
                }
            }

            // Clear cart
            $cartItems->each->delete();

            DB::commit();

            session()->forget('coupon');

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect' => route('orders.show', $order),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to process order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show order confirmation
     */
    public function show(Order $order)
    {
        // Ensure order belongs to current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order');
        }

        $order->load(['items.product', 'items.variant']);

        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Buy now (quick order from product page)
     */
    public function buyNow(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to place an order.',
                'redirect' => route('login'),
            ], 401);
        }

        try {
            $product = Product::findOrFail($request->product_id);
            $variant = null;
            $unitPrice = $product->current_price;

            // If variant is specified, get variant details
            if ($request->variant_id) {
                $variant = ProductVariant::findOrFail($request->variant_id);
                // Use product's current price (respects sales)
                $unitPrice = $product->current_price;

                // Check stock availability - must have enough quantity
                if ($variant->stock_quantity < $request->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock. Available: {$variant->stock_quantity}",
                    ], 400);
                }
            }

            // Check product stock if no variant
            if (!$variant && !$product->isInStock()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock.',
                ], 400);
            }

            DB::beginTransaction();

            // Calculate totals
            $subtotal = $unitPrice * $request->quantity;
            $taxAmount = 0; // No tax

            // Calculate shipping using ShippingService
            $shippingAmount = $this->calculateShippingAmount($request, $subtotal);

            $totalAmount = $subtotal + $taxAmount + $shippingAmount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
                'currency' => 'BDT',
                'payment_status' => 'pending',
                'payment_method' => 'cash_on_delivery', // Default to cash on delivery
                'billing_address' => [], // Will be collected at checkout
                'shipping_address' => [], // Will be collected at checkout
                'shipping_method' => 'standard',
            ]);

            // Create order item
            $attributes = [];
            if ($variant) {
                $attributes = [
                    'color' => $variant->color ? $variant->color->name : null,
                    'size' => $variant->size ? $variant->size->name : null,
                    'variant_name' => $variant->name,
                ];
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_variant_id' => $request->variant_id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $subtotal,
                'product_attributes' => $attributes,
            ]);

            // Update product sales count
            $product->increment('sales_count', $request->quantity);

            // Reduce stock if variant exists
            if ($variant) {
                $variant->decrement('stock_quantity', $request->quantity);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect' => route('orders.show', $order),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to place order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cart items for the current user or session
     */
    private function getUserCartItems()
    {
        $query = Cart::with(['product' => function($query) {
                    $query->with('images');
                }, 'variant'])
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

        $cartItems = $query->get();

        \Log::info('Cart items retrieved:', [
            'user_id' => Auth::id(),
            'session_id' => session('cart_session_id'),
            'count' => $cartItems->count(),
            'items' => $cartItems->toArray()
        ]);

        return $cartItems;
    }

    /**
     * Get or generate session ID for guest users
     */
    private function getSessionId()
    {
        if (!Auth::check()) {
            $sessionId = session('cart_session_id');
            if (!$sessionId) {
                $sessionId = \Illuminate\Support\Str::uuid()->toString();
                session(['cart_session_id' => $sessionId]);
            }
            return $sessionId;
        }
        return null;
    }

    /**
     * Calculate shipping charge via AJAX (returns JSON with shipping and advance charges)
     */
    public function calculateShipping(Request $request): JsonResponse
    {
        try {
            // Get cart items to calculate subtotal - Use bcadd for precise decimal arithmetic
            $cartItems = $this->getUserCartItems();
            $subtotal = $cartItems->reduce(function ($carry, $item) {
                return bcadd($carry, (string)$item->total_price, 2);
            }, '0');

            // Calculate shipping charge
            $shippingCharge = $this->calculateShippingAmount($request, $subtotal);

            // Get advance payment settings
            $advancePaymentSettings = AdvancePaymentSetting::current();
            $advanceCharge = 0;
            $advanceRequired = false;

            if ($advancePaymentSettings && $advancePaymentSettings->advance_payment_status) {
                $advanceCharge = (float) $advancePaymentSettings->advance_payment_amount;
                $advanceRequired = true;
            }

            return response()->json([
                'success' => true,
                'shipping_charge' => $shippingCharge,
                'advance_charge' => $advanceCharge,
                'advance_required' => $advanceRequired,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in calculateShipping: ' . $e->getMessage());

            // Return default values on error
            $defaultShipping = $this->shippingService->getDefaultShippingCharge();
            $advancePaymentSettings = AdvancePaymentSetting::current();
            $advanceCharge = 0;
            $advanceRequired = false;

            if ($advancePaymentSettings && $advancePaymentSettings->advance_payment_status) {
                $advanceCharge = (float) $advancePaymentSettings->advance_payment_amount;
                $advanceRequired = true;
            }

            return response()->json([
                'success' => false,
                'error' => 'Unable to calculate shipping charge. Using default.',
                'shipping_charge' => $defaultShipping,
                'advance_charge' => $advanceCharge,
                'advance_required' => $advanceRequired,
            ], 500);
        }
    }

    /**
     * Calculate shipping amount using ShippingService
     */
    private function calculateShippingAmount(Request $request, $subtotal): float
    {
        // Convert subtotal to float if it's a string (from bcadd)
        $subtotalFloat = is_string($subtotal) ? (float)$subtotal : (float)$subtotal;
        
        // Check if free shipping threshold is met
        if ($subtotalFloat > 1000) {
            return 0;
        }

        // Get shipping address from request
        $division = $request->input('division') ?? $request->input('division_name');
        $district = $request->input('district') ?? $request->input('zone_name');

        // If division or district is missing, fall back to default shipping
        if (empty($division) || empty($district)) {
            return $this->shippingService->getDefaultShippingCharge();
        }

        try {
            return $this->shippingService->calculateShippingCharge($division, $district);
        } catch (\Exception $e) {
            \Log::error('Error calculating shipping charge: ' . $e->getMessage());
            return $this->shippingService->getDefaultShippingCharge();
        }
    }
}
