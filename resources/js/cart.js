document.addEventListener('DOMContentLoaded', function () {
  const cartOffcanvas = document.getElementById('cart-offcanvas');
  const cartOverlay = document.getElementById('cart-overlay');
  const closeCartButton = document.getElementById('close-cart');
  const openCartButtons = document.querySelectorAll('.open-cart');
  const cartLoading = document.getElementById('cart-loading');

  function openCart() {
    cartOffcanvas.classList.remove('translate-x-full');
    cartOverlay.classList.remove('hidden');
  }

  function closeCart() {
    cartOffcanvas.classList.add('translate-x-full');
    cartOverlay.classList.add('hidden');
  }

  openCartButtons.forEach(button => {
    button.addEventListener('click', openCart);
  });

  closeCartButton.addEventListener('click', closeCart);
  cartOverlay.addEventListener('click', closeCart);

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('add-to-cart')) {
      const productId = e.target.dataset.productId;
      const productVariantId = document.getElementById(`product-variant-id-${productId}`).value;
      showLoading();

      fetch('/cart', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
          product_id: productId, 
          product_variant_id: productVariantId, 
          quantity: 1 
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          openCart();
          updateCartView(data.cart_items, data.subtotal);
          updateCartCount(data.total_items);
          showToast('Item added to cart');
        }
      })
      .finally(() => {
        hideLoading();
      });
    }

    if (e.target.classList.contains('remove-from-cart')) {
      const cartItemId = e.target.dataset.itemId;
      showLoading();

      fetch(`/cart/${cartItemId}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          updateCartView(data.cart_items, data.subtotal);
          updateCartCount(data.total_items);
        }
      })
      .finally(() => {
        hideLoading();
      });
    }

    if (e.target.classList.contains('quantity-change')) {
      const cartItemId = e.target.dataset.itemId;
      const change = e.target.dataset.change;
      showLoading();

      fetch(`/cart/${cartItemId}` , {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ change: change })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          updateCartView(data.cart_items, data.subtotal);
        }
      })
      .finally(() => {
        hideLoading();
      });
    }
  });

  function updateCartView(cartItems, subtotal) {
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cartShipping = document.getElementById('cart-shipping');
    const cartTotal = document.getElementById('cart-total');

    cartItemsContainer.innerHTML = '';

    if (cartItems.length > 0) {
      cartItems.forEach(item => {
        cartItemsContainer.innerHTML += `
          <div id="cart-item-${item.id}" class="flex items-center p-4">
            <div class="w-20 h-20 mr-4">
              <img src="${item.product.image_url}" alt="${item.product.name}" class="w-full h-full object-cover rounded-lg">
            </div>
            <div class="flex-grow">
              <h3 class="text-lg font-semibold text-gray-800">${item.product.name}</h3>
              <p class="text-gray-600">${item.product_variant.size.name} / ${item.product_variant.color.name}</p>
              <div class="flex items-center mt-2">
                <div class="flex items-center border border-gray-300 rounded-md">
                  <button class="quantity-change text-gray-600 hover:text-gray-800 focus:outline-none px-2" data-item-id="${item.id}" data-change="-1">-</button>
                  <span class="quantity text-gray-800 px-3">${item.quantity}</span>
                  <button class="quantity-change text-gray-600 hover:text-gray-800 focus:outline-none px-2" data-item-id="${item.id}" data-change="1">+</button>
                </div>
                <p class="text-lg font-bold text-gray-800 ml-auto">৳${item.product.price * item.quantity}</p>
              </div>
            </div>
            <button class="remove-from-cart text-gray-500 hover:text-red-600 focus:outline-none ml-4" data-item-id="${item.id}">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        `;
      });
    } else {
      cartItemsContainer.innerHTML = '<div class="text-center py-12"><p class="text-lg text-gray-600">Your cart is empty.</p></div>';
    }

    const shippingCost = subtotal > 1000 ? 0 : 100;
    cartSubtotal.textContent = `৳${subtotal}`;
    cartShipping.textContent = shippingCost === 0 ? 'Free' : `৳${shippingCost}`;
    cartTotal.textContent = `৳${subtotal + shippingCost}`;
  }

  function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
      element.textContent = count;
    });
  }

  function showLoading() {
    cartLoading.classList.remove('hidden');
  }

  function hideLoading() {
    cartLoading.classList.add('hidden');
  }

  function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-5 right-5 bg-gray-900 text-white px-4 py-2 rounded-md';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.remove();
    }, 3000);
  }
});