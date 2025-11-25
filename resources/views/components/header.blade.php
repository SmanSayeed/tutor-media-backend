@php
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
    $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
    $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
@endphp
<!-- Header -->
<header class="bg-white/95 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-50 shadow-sm">
  <!-- Top Row: Logo, Search, User/Cart -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
    <div class="flex items-center justify-between">
      <!-- Left: logo + hamburger (hamburger only visible on mobile) -->
      <div class="flex items-center gap-2 sm:gap-3 order-1 lg:order-none">
        <button id="nav-toggle" class="p-2 -ml-2 rounded-lg hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 md:hidden transition-all duration-200" style="--tw-ring-color: {{ $primaryColor }};" aria-label="Open Menu" onclick="triggerNavDrawer()">
          <svg class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <a href="/" class="flex items-center group relative" aria-label="{{ $websiteName }} - Home">
          @if($logoUrl)
            <!-- Logo Image with Enhanced Styling -->
            <div class="relative overflow-hidden rounded-lg transition-all duration-300 group-hover:scale-105 group-hover:shadow-md">
              <div class="absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-10 transition-opacity duration-300" style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $accentColor }});"></div>
              <img src="{{ $logoUrl }}" 
                   alt="{{ $websiteName }}" 
                   class="h-8 sm:h-10 w-auto object-contain relative z-10 transition-transform duration-300 group-hover:scale-110"
                   loading="eager">
            </div>
            <!-- Optional: Add website name next to logo on larger screens -->
            <span class="ml-2 hidden lg:block text-sm font-semibold text-slate-900 group-hover:text-slate-700 transition-colors duration-200">
              {{ $websiteName }}
            </span>
          @else
            <!-- Enhanced Text Logo with Badge Design -->
            <div class="flex items-center gap-2">
              <!-- Logo Badge -->
              <div class="relative">
                <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm" style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $accentColor }});"></div>
                <div class="relative flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-xl font-black text-white shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl group-hover:rotate-3" 
                     style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $accentColor }} 100%);">
                  <span class="text-lg sm:text-xl">{{ strtoupper(substr($websiteName, 0, 1)) }}</span>
                </div>
              </div>
              <!-- Website Name -->
              <div class="flex flex-col">
                <span class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-slate-700 transition-colors duration-200 leading-tight">
                  {{ $websiteName }}
                </span>
                @php
                  $tagline = \App\Helpers\SiteSettingsHelper::tagline();
                @endphp
                @if($tagline)
                  <span class="text-xs text-slate-500 hidden sm:block">{{ $tagline }}</span>
                @endif
              </div>
            </div>
          @endif
        </a>
      </div>

      <!-- Center: search (expandable on mobile) -->
      <div class="hidden lg:flex flex-1 max-w-md mx-4 sm:mx-8 order-3 lg:order-none" id="searchContainer">
  <form action="{{ route('products.search') }}" method="GET" class="relative w-full" data-search-form data-search-placeholder-image="https://via.placeholder.com/96x96?text=No+Image">
          <input
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search for products..."
            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200"
            style="--tw-ring-color: {{ $primaryColor }};"
            required
            autocomplete="off"
            data-search-input
          />
          <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-white p-1.5 rounded-md transition-colors duration-200" style="background-color: {{ $primaryColor }}; --tw-ring-color: {{ $primaryColor }};" onmouseover="this.style.backgroundColor='{{ $accentColor }}'" onmouseout="this.style.backgroundColor='{{ $primaryColor }}'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
          </button>
          <div class="absolute left-0 right-0 top-full mt-2 hidden rounded-2xl border border-slate-200 bg-white shadow-xl" data-search-suggestions>
            <div class="max-h-80 overflow-y-auto">
              <ul class="divide-y divide-slate-100" data-search-suggestions-list></ul>
            </div>
            <div class="hidden px-4 py-3 text-sm text-slate-500" data-search-suggestions-empty>No results found.</div>
          </div>
        </form>
      </div>

      <!-- Mobile search icon -->
      <button onclick="toggleSearch()" class="lg:hidden order-2 p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
        </svg>
      </button>

      <!-- Right: user & cart (always visible) -->
      <div class="flex items-center gap-1 sm:gap-2 md:gap-4 order-2 lg:order-none">
        <!-- Modern Login Component -->
        <x-login-dropdown />

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="relative text-slate-700 hover:text-slate-900 p-1.5 sm:p-2 rounded-lg hover:bg-slate-100 transition-all duration-200 group">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256"><path d="M230.14,58.87A8,8,0,0,0,224,56H62.68L56.6,22.57A8,8,0,0,0,48.73,16H24a8,8,0,0,0,0,16h18L67.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,160,204a28,28,0,1,0,28-28H91.17a8,8,0,0,1-7.87-6.57L80.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,230.14,58.87ZM104,204a12,12,0,1,1-12-12A12,12,0,0,1,104,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,200,204Zm4-74.57A8,8,0,0,1,196.1,136H77.22L65.59,72H214.41Z"></path></svg>
          <span class="cart-count absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 text-white text-xs rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center font-medium group-hover:scale-110 transition-transform duration-200" style="background-color: {{ $accentColor }};" data-cart-count="0">0</span>
        </a>
      </div>
    </div>
  </div>

</header>

<!-- Header interaction scripts -->
<script>
  function triggerNavDrawer() {
    // Dispatch event for the nav-drawer component to listen for
    const event = new CustomEvent('toggle-drawer', { detail: { open: true } });
    window.dispatchEvent(event);
  }

  // Mobile search toggle
  function toggleSearch() {
    const searchContainer = document.getElementById('searchContainer');
    if (searchContainer) {
      // Toggle visibility
      if (searchContainer.classList.contains('hidden')) {
        // Show search
        searchContainer.classList.remove('hidden');
        searchContainer.classList.add('flex', 'fixed', 'inset-x-0', 'top-16', 'p-4', 'bg-white', 'shadow-md', 'z-50');
        // Focus the input
        searchContainer.querySelector('input').focus();
      } else {
        // Hide search
        searchContainer.classList.add('hidden');
        searchContainer.classList.remove('flex', 'fixed', 'inset-x-0', 'top-16', 'p-4', 'bg-white', 'shadow-md', 'z-50');
      }
    }
  }

  // Close search when clicking outside (mobile)
  document.addEventListener('click', (e) => {
    const searchContainer = document.getElementById('searchContainer');
    const searchButton = e.target.closest('button[onclick="toggleSearch()"]');
    const isClickInside = searchContainer?.contains(e.target) || searchButton;

    if (!isClickInside && searchContainer && !searchContainer.classList.contains('hidden') && window.innerWidth < 1024) {
      toggleSearch();
    }
  });

  // Load cart count on page load
  document.addEventListener('DOMContentLoaded', function() {
    loadCartCount();
    initSearchSuggestions();
  });

  function loadCartCount() {
    fetch('{{ route("cart.count") }}', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      if (data.cart_count !== undefined) {
        updateCartCount(data.cart_count);
      }
    })
    .catch(error => {
      console.error('Error loading cart count:', error);
    });
  }

  function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count, [data-cart-count]');
    cartCountElements.forEach(element => {
      if (element.tagName === 'SPAN' || element.tagName === 'DIV') {
        element.textContent = count;
      } else {
        element.setAttribute('data-cart-count', count);
      }
    });
  }

  function initSearchSuggestions() {
    const forms = document.querySelectorAll('[data-search-form]');
    if (!forms.length) {
      return;
    }

    const endpoint = '{{ route('products.suggest') }}';
    const currencyLabel = 'BDT ';

    forms.forEach((form) => {
      const input = form.querySelector('[data-search-input]');
      const container = form.querySelector('[data-search-suggestions]');
      const list = form.querySelector('[data-search-suggestions-list]');
      const emptyState = form.querySelector('[data-search-suggestions-empty]');

      if (!input || !container || !list) {
        return;
      }

      let debounceTimer;
      let activeIndex = -1;
      let currentItems = [];
      let abortController = null;

      const emptyStateDefaultText = emptyState ? emptyState.textContent : '';

      const closeSuggestions = () => {
        if (abortController) {
          abortController.abort();
          abortController = null;
        }
        activeIndex = -1;
        currentItems = [];
        list.innerHTML = '';
        container.classList.add('hidden');
        if (emptyState) {
          emptyState.textContent = emptyStateDefaultText;
          emptyState.classList.add('hidden');
        }
      };

      const formatPrice = (price) => {
        if (price === undefined || price === null) {
          return '';
        }

        const numericPrice = typeof price === 'number' ? price : Number.parseFloat(price);

        if (Number.isNaN(numericPrice)) {
          return '';
        }

        return currencyLabel + numericPrice.toLocaleString();
      };

      const placeholderImage = form.getAttribute('data-search-placeholder-image') || 'https://via.placeholder.com/96x96?text=No+Image';

      const escapeFallbackText = (value, fallback) => {
        if (value === undefined || value === null) {
          return fallback;
        }

        const stringValue = String(value).trim();
        return stringValue !== '' ? stringValue : fallback;
      };

      const showEmptyState = (message) => {
        if (!emptyState) {
          return;
        }
        list.innerHTML = '';
        emptyState.textContent = message;
        emptyState.classList.remove('hidden');
        container.classList.remove('hidden');
      };

      const showLoadingState = () => {
        if (!emptyState) {
          return;
        }
        list.innerHTML = '';
        emptyState.textContent = 'Searching...';
        emptyState.classList.remove('hidden');
        container.classList.remove('hidden');
      };

      const renderSuggestions = (items) => {
        currentItems = items;
        activeIndex = -1;
        list.innerHTML = '';

        if (!items.length) {
          showEmptyState(emptyStateDefaultText || 'No results found.');
          return;
        }

        if (emptyState) {
          emptyState.classList.add('hidden');
        }

        items.forEach((item, index) => {
          const li = document.createElement('li');
          li.setAttribute('data-index', index.toString());

          const productUrl = `${window.location.origin}/product/${encodeURIComponent(item.slug)}`;
          const imageSrc = item.image || placeholderImage;

          const anchor = document.createElement('a');
          anchor.href = productUrl;
          anchor.dataset.suggestionLink = '';
          anchor.className = 'flex items-center gap-3 px-4 py-3 hover:bg-slate-50 focus:bg-slate-100 focus:outline-none';

          const thumbnail = document.createElement('div');
          thumbnail.className = 'h-12 w-12 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0';

          const image = document.createElement('img');
          image.src = imageSrc;
          image.alt = escapeFallbackText(item.name, 'Product image');
          image.loading = 'lazy';
          image.className = 'h-full w-full object-cover';
          thumbnail.appendChild(image);

          const body = document.createElement('div');
          body.className = 'flex-1 min-w-0';

          const nameEl = document.createElement('p');
          nameEl.className = 'text-sm font-semibold text-slate-900 truncate';
          nameEl.textContent = escapeFallbackText(item.name, 'Unnamed product');
          body.appendChild(nameEl);

          const meta = document.createElement('div');
          meta.className = 'mt-0.5 flex items-center gap-3 text-xs text-slate-500';

          const skuSpan = document.createElement('span');
          skuSpan.textContent = `SKU: ${escapeFallbackText(item.sku, 'N/A')}`;
          meta.appendChild(skuSpan);

          if (item.brand) {
            const brandSpan = document.createElement('span');
            brandSpan.className = 'hidden sm:inline';
            brandSpan.textContent = escapeFallbackText(item.brand, '');
            meta.appendChild(brandSpan);
          }

          body.appendChild(meta);

          const priceEl = document.createElement('p');
          priceEl.className = 'mt-1 text-sm font-semibold';
          priceEl.style.color = '{{ $accentColor }}';
          priceEl.textContent = formatPrice(item.price);
          body.appendChild(priceEl);

          anchor.appendChild(thumbnail);
          anchor.appendChild(body);
          li.appendChild(anchor);

          li.addEventListener('mouseenter', () => {
            setActiveIndex(index);
          });

          list.appendChild(li);
        });

        container.classList.remove('hidden');
      };

      const setActiveIndex = (index) => {
        const links = list.querySelectorAll('[data-suggestion-link]');
        links.forEach((link) => link.classList.remove('bg-slate-100'));

        activeIndex = index;
        if (activeIndex >= 0 && links[activeIndex]) {
          links[activeIndex].classList.add('bg-slate-100');
          links[activeIndex].scrollIntoView({ block: 'nearest' });
        }
      };

      const fetchSuggestions = (query) => {
        if (abortController) {
          abortController.abort();
        }

        abortController = new AbortController();
        showLoadingState();

        fetch(`${endpoint}?q=${encodeURIComponent(query)}`, {
          signal: abortController.signal,
          headers: {
            'Accept': 'application/json',
          },
        })
          .then((response) => response.ok ? response.json() : Promise.reject())
          .then((payload) => {
            abortController = null;
            renderSuggestions(payload.data || []);
          })
          .catch((error) => {
            if (error.name === 'AbortError') {
              return;
            }
            abortController = null;
            showEmptyState('Unable to load suggestions.');
            console.error('Suggestion error:', error);
          });
      };

      input.addEventListener('input', (event) => {
        const value = event.target.value.trim();

        if (value.length < 2) {
          closeSuggestions();
          return;
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          fetchSuggestions(value);
        }, 200);
      });

      input.addEventListener('focus', () => {
        if (currentItems.length) {
          container.classList.remove('hidden');
        }
      });

      input.addEventListener('keydown', (event) => {
        const { key } = event;
        if (!currentItems.length) {
          return;
        }

        if (key === 'ArrowDown') {
          event.preventDefault();
          const nextIndex = activeIndex + 1 >= currentItems.length ? 0 : activeIndex + 1;
          setActiveIndex(nextIndex);
        } else if (key === 'ArrowUp') {
          event.preventDefault();
          const nextIndex = activeIndex - 1 < 0 ? currentItems.length - 1 : activeIndex - 1;
          setActiveIndex(nextIndex);
        } else if (key === 'Enter' && activeIndex >= 0) {
          event.preventDefault();
          const links = list.querySelectorAll('[data-suggestion-link]');
          links[activeIndex]?.click();
        } else if (key === 'Escape') {
          closeSuggestions();
        }
      });

      form.addEventListener('submit', () => {
        closeSuggestions();
      });

      document.addEventListener('click', (event) => {
        if (!form.contains(event.target)) {
          closeSuggestions();
        }
      });
    });
  }
</script>
