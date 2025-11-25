@props(['cartItems', 'subtotal'])

<div {{ $attributes->merge(['class' => '']) }}>
  <div id="cart-offcanvas" class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="flex flex-col h-full">
      <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800" id="cart-heading">Your Cart</h2>
        <button id="close-cart" class="text-gray-600 hover:text-gray-800 focus:outline-none" aria-label="Close cart">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="flex-grow overflow-y-auto" aria-labelledby="cart-heading">
        <div id="cart-items-container" class="divide-y divide-gray-200">
        <div id="cart-loading" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center" aria-live="polite" aria-label="Loading cart items">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-gray-900"></div>
        </div>
          @if ($cartItems->count() > 0)
            @foreach ($cartItems as $item)
              <div id="cart-item-{{ $item->id }}" class="flex items-center p-4">
                <div class="w-20 h-20 mr-4">
                  <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="flex-grow">
                  <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                  <p class="text-gray-600">
                    {{ $item->product_variant->size->name }} / {{ $item->product_variant->color->name }}
                  </p>
                  <div class="flex items-center mt-2">
                    <div class="flex items-center border border-gray-300 rounded-md">
                      <button class="quantity-change text-gray-600 hover:text-gray-800 focus:outline-none px-2" data-item-id="{{ $item->id }}" data-change="-1" aria-label="Decrease quantity of {{ $item->product->name }}">
                        -
                      </button>
                      <span class="quantity text-gray-800 px-3" aria-live="polite">{{ $item->quantity }}</span>
                      <button class="quantity-change text-gray-600 hover:text-gray-800 focus:outline-none px-2" data-item-id="{{ $item->id }}" data-change="1" aria-label="Increase quantity of {{ $item->product->name }}">
                        +
                      </button>
                    </div>
                    <p class="text-lg font-bold text-gray-800 ml-auto">
                      ৳{{ $item->product->price * $item->quantity }}
                    </p>
                  </div>
                </div>
                <button class="remove-from-cart text-gray-500 hover:text-red-600 focus:outline-none ml-4" data-item-id="{{ $item->id }}" aria-label="Remove {{ $item->product->name }} from cart">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            @endforeach
          @else
            <div class="text-center py-12">
              <p class="text-lg text-gray-600">Your cart is empty.</p>
            </div>
          @endif
        </div>
      </div>

      <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex justify-between items-center mb-2">
          <p class="text-lg text-gray-700">Subtotal</p>
          <p id="cart-subtotal" class="text-lg font-semibold text-gray-800" aria-live="polite">৳{{ $subtotal }}</p>
        </div>
        <div class="flex justify-between items-center mb-4">
          <p class="text-lg text-gray-700">Shipping</p>
          <p id="cart-shipping" class="text-lg font-semibold text-gray-800" aria-live="polite">
            {{ $subtotal > 1000 ? 'Free' : '৳0' }}
          </p>
        </div>
        <div class="flex justify-between items-center border-t border-gray-300 pt-4">
          <p class="text-xl font-bold text-gray-800">Total</p>
          <p id="cart-total" class="text-xl font-bold text-gray-800" aria-live="polite">
            ৳{{ $subtotal > 1000 ? $subtotal : $subtotal + 100 }}
          </p>
        </div>
        <a href="{{ route('checkout') }}" class="block w-full text-center bg-blue-600 text-white font-semibold py-3 rounded-md mt-6 hover:bg-blue-700 transition-colors duration-300">
          Proceed to Checkout
        </a>
      </div>
    </div>
  </div>

  <div id="cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
</div>
