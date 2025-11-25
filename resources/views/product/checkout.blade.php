<x-app-layout title="Checkout">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 py-4 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Product</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium">Checkout</span>
            </div>
        </div>
    </div>

    <!-- Main Checkout Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="#" method="POST" class="checkout-container">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Forms -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Customer Information -->
                    <section class="form-section p-6">
                        <div class="flex items-center mb-6">
                            <div
                                class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full text-sm font-medium mr-3">
                                1
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Billing Information</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <input type="text" id="first_name" name="first_name" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="first_name" class="text-gray-600">First Name *</label>
                            </div>

                            <div class="input-group">
                                <input type="text" id="last_name" name="last_name" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="last_name" class="text-gray-600">Last Name *</label>
                            </div>

                            <div class="input-group">
                                <input type="email" id="email" name="email" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="email" class="text-gray-600">Email Address *</label>
                            </div>

                            <div class="input-group">
                                <input type="tel" id="phone" name="phone" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="phone" class="text-gray-600">Phone Number *</label>
                            </div>

                            <div class="input-group md:col-span-2">
                                <input type="text" id="address" name="address" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="address" class="text-gray-600">Address Line 1 *</label>
                            </div>

                            <div class="input-group md:col-span-2">
                                <input type="text" id="address_2" name="address_2" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <label for="address_2" class="text-gray-600">Address Line 2 (Optional)</label>
                            </div>

                            <div class="input-group">
                                <input type="text" id="city" name="city" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="city" class="text-gray-600">City/District *</label>
                            </div>

                            <div class="input-group">
                                <input type="text" id="postal_code" name="postal_code" placeholder=" "
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    required>
                                <label for="postal_code" class="text-gray-600">Postal Code *</label>
                            </div>
                        </div>
                    </section>

                    <!-- Shipping Information -->
                    <section class="form-section p-6">
                        <div class="flex items-center mb-6">
                            <div
                                class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-medium mr-3">
                                2
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Shipping Information</h3>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" id="same_as_billing" name="same_as_billing"
                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2"
                                    checked>
                                <span class="text-gray-700 font-medium">Same as billing address</span>
                            </label>
                        </div>

                        <div id="shipping_form" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="input-group">
                                    <input type="text" id="shipping_first_name" name="shipping_first_name"
                                        placeholder=" "
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <label for="shipping_first_name" class="text-gray-600">First Name *</label>
                                </div>

                                <div class="input-group">
                                    <input type="text" id="shipping_last_name" name="shipping_last_name" placeholder=" "
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <label for="shipping_last_name" class="text-gray-600">Last Name *</label>
                                </div>

                                <div class="input-group md:col-span-2">
                                    <input type="text" id="shipping_address" name="shipping_address" placeholder=" "
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <label for="shipping_address" class="text-gray-600">Address Line 1 *</label>
                                </div>

                                <div class="input-group">
                                    <input type="text" id="shipping_city" name="shipping_city" placeholder=" "
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <label for="shipping_city" class="text-gray-600">City/District *</label>
                                </div>

                                <div class="input-group">
                                    <input type="tel" id="shipping_phone" name="shipping_phone" placeholder=" "
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <label for="shipping_phone" class="text-gray-600">Phone Number *</label>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Methods -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Shipping Method</h4>
                            <div class="space-y-3">
                                <label
                                    class="payment-option flex items-center justify-between p-4 rounded-lg cursor-pointer">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" value="inside_dhaka"
                                            class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2"
                                            checked>
                                        <div class="ml-3">
                                            <span class="font-medium text-gray-900">Inside Dhaka</span>
                                            <p class="text-sm text-gray-500">Delivery within 1-2 business days</p>
                                        </div>
                                    </div>
                                    <span class="text-lg font-semibold text-gray-900">৳80</span>
                                </label>

                                <label
                                    class="payment-option flex items-center justify-between p-4 rounded-lg cursor-pointer">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" value="outside_dhaka"
                                            class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                                        <div class="ml-3">
                                            <span class="font-medium text-gray-900">Outside Dhaka</span>
                                            <p class="text-sm text-gray-500">Delivery within 3-5 business days</p>
                                        </div>
                                    </div>
                                    <span class="text-lg font-semibold text-gray-900">৳120</span>
                                </label>

                                <label
                                    class="payment-option flex items-center justify-between p-4 rounded-lg cursor-pointer">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" value="express"
                                            class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                                        <div class="ml-3">
                                            <span class="font-medium text-gray-900">Express Delivery</span>
                                            <p class="text-sm text-gray-500">Same day delivery (Dhaka only)</p>
                                        </div>
                                    </div>
                                    <span class="text-lg font-semibold text-gray-900">৳200</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <!-- Payment Method -->
                    <section class="form-section p-6">
                        <div class="flex items-center mb-6">
                            <div
                                class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-medium mr-3">
                                3
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Payment Method</h3>
                        </div>

                        <div class="space-y-4">
                            <label class="payment-option flex items-center p-4 rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" value="cod"
                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2"
                                    checked>
                                <div class="ml-3 flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">Cash on Delivery</span>
                                        <p class="text-sm text-gray-500">Pay when you receive your order</p>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-option flex items-center p-4 rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" value="bkash"
                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                                <div class="ml-3 flex items-center">
                                    <div class="bg-pink-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">bKash</span>
                                        <p class="text-sm text-gray-500">Pay securely with bKash</p>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-option flex items-center p-4 rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" value="nagad"
                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                                <div class="ml-3 flex items-center">
                                    <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">Nagad</span>
                                        <p class="text-sm text-gray-500">Pay securely with Nagad</p>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-option flex items-center p-4 rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" value="rocket"
                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 focus:ring-2">
                                <div class="ml-3 flex items-center">
                                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">Rocket</span>
                                        <p class="text-sm text-gray-500">Pay securely with Rocket</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="form-section order-summary-card p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Your Order</h3>

                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=80&h=80&fit=crop"
                                    alt="Product" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">Premium Leather Shoes</h4>
                                    <p class="text-sm text-gray-500">Size: 42, Color: Brown</p>
                                    <p class="text-sm text-gray-500">Qty: 1</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">৳2,499</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=80&h=80&fit=crop"
                                    alt="Product" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">Leather Wallet</h4>
                                    <p class="text-sm text-gray-500">Color: Black</p>
                                    <p class="text-sm text-gray-500">Qty: 1</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">৳799</p>
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-6">
                            <div class="flex space-x-2">
                                <input type="text" placeholder="Promo code"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <button type="button"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="border-t pt-6 space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>৳3,298</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span id="shipping-cost">৳80</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax</span>
                                <span>৳0</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span id="total-cost">৳3,378</span>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit"
                            class="w-full mt-6 bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Place Order
                        </button>

                        <!-- Security Info -->
                        <div class="mt-4 text-center">
                            <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Secure SSL encrypted checkout</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            // Toggle shipping form
            document.getElementById('same_as_billing').addEventListener('change', function () {
                const shippingForm = document.getElementById('shipping_form');
                if (this.checked) {
                    shippingForm.classList.add('hidden');
                } else {
                    shippingForm.classList.remove('hidden');
                }
            });

            // Update shipping cost and total
            document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    const shippingCostElement = document.getElementById('shipping-cost');
                    const totalCostElement = document.getElementById('total-cost');
                    const subtotal = 3298;

                    let shippingCost = 0;
                    switch (this.value) {
                        case 'inside_dhaka':
                            shippingCost = 80;
                            break;
                        case 'outside_dhaka':
                            shippingCost = 120;
                            break;
                        case 'express':
                            shippingCost = 200;
                            break;
                    }

                    shippingCostElement.textContent = `৳${shippingCost}`;
                    totalCostElement.textContent = `৳${subtotal + shippingCost}`;
                });
            });

            // Payment method selection visual feedback
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    // Remove active class from all payment options
                    document.querySelectorAll('.payment-option').forEach(option => {
                        option.classList.remove('active');
                    });
                    // Add active class to selected option
                    this.closest('.payment-option').classList.add('active');
                });
            });

            // Initialize first payment method as active
            document.querySelector('input[name="payment_method"]:checked').closest('.payment-option').classList.add('active');

            // Form validation and submission
            document.querySelector('form').addEventListener('submit', function (e) {
                e.preventDefault();

                // Basic validation
                const requiredFields = document.querySelectorAll('input[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                if (isValid) {
                    alert('Order placed successfully! (This is a demo)');
                } else {
                    alert('Please fill in all required fields.');
                }
            });
        </script>
    @endpush
</x-app-layout>