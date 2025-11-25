<x-admin-layout title="Manage Stock">
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <div>
            <h5>Manage Stock - {{ $product->name }}</h5>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage stock quantities for each product variant
            </p>
        </div>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}">Products</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.show', $product) }}">Product Details</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Manage Stock</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Stock Management Starts -->
    <div class="space-y-6">
        <!-- Product Info Card -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        @if($product->main_image)
                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                                <i class="text-slate-400" data-feather="package"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}</h6>
                            <p class="text-sm text-slate-500 dark:text-slate-400">SKU: {{ $product->sku }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="badge badge-info">
                                    {{ $product->variants->count() }} Variants
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Stock</p>
                        <p class="text-2xl font-bold text-slate-800 dark:text-slate-200">
                            {{ $product->totalStock() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Variants Stock Management -->
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h6 class="card-title">Product Variants Stock</h6>    
                </div>
            </div>

            <div class="card-body">
                <!-- Bulk Operations Section -->
                <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg bulk-operations">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Quick Actions:
                                </label>
                                <button type="button" class="btn btn-sm btn-outline-primary quick-action-btn"
                                    onclick="bulkSetStock(10)" title="Set all visible variants to 10">
                                    <i data-feather="plus" class="w-4 h-4"></i>
                                    Set All to 10
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success quick-action-btn"
                                    onclick="bulkSetStock(50)" title="Set all visible variants to 50">
                                    <i data-feather="plus" class="w-4 h-4"></i>
                                    Set All to 50
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success quick-action-btn"
                                    onclick="bulkSetStock(100)" title="Set all visible variants to 100">
                                    <i data-feather="plus" class="w-4 h-4"></i>
                                    Set All to 100
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="stock-search" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Search Variants:
                            </label>
                            <div class="relative">
                                <input type="text" id="stock-search" class="input input-sm w-48 pl-8"
                                    placeholder="Search by size..."
                                    onkeyup="filterVariants(this.value)">
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Update Controls -->
                    <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="select-all-variants" class="checkbox variant-checkbox"
                                        onchange="toggleSelectAll()">
                                    <label for="select-all-variants" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                        Select All Visible
                                    </label>
                                </div>

                                <div class="flex items-center gap-2">
                                    <label for="bulk-stock-value" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                        Set Selected to:
                                    </label>
                                    <input type="number" id="bulk-stock-value" class="input input-sm !w-16 text-center"
                                        placeholder="0" min="0" disabled
                                        onkeydown="if(event.key==='Enter') bulkUpdateSelected()">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="bulkUpdateSelected()" id="bulk-update-btn" disabled>
                                        <i data-feather="refresh-cw" class="w-4 h-4"></i>
                                        Update Selected
                                    </button>
                                </div>
                            </div>

                            <!-- Selection summary -->
                            <div class="text-xs text-slate-500 dark:text-slate-400" id="selection-summary">
                                <span id="selected-count">0</span> of <span id="total-count">{{ $product->variants->count() }}</span> variants selected
                            </div>                        
                        </div>
                    </div>
                </div>

                @if($product->variants->count() > 0)
                    <div class="space-y-4" id="variants-container">
                        @foreach($product->variants as $variant)
                            <div class="variant-row border border-slate-200 dark:border-slate-700 rounded-lg p-4"
                                data-variant-id="{{ $variant->id }}"
                                data-name="{{ strtolower($variant->name) }}"
                                data-sku="{{ strtolower($variant->sku) }}"
                                data-size="{{ $variant->size ? strtolower($variant->size->name) : '' }}"
                                data-color="{{ $variant->color ? strtolower($variant->color->name) : '' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <!-- Selection checkbox -->
                                        <input type="checkbox" class="variant-checkbox checkbox"
                                            id="variant_{{ $variant->id }}"
                                            value="{{ $variant->id }}"
                                            onchange="updateBulkControls()">

                                        @if($variant->image)
                                            <img src="{{ asset($variant->image) }}" alt="{{ $variant->name }}"
                                                class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="text-slate-400" data-feather="package"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="flex items-center gap-2">                                             
                                                @if($variant->size)
                                                    <span class="text-lg">Size:
                                                        {{ $variant->size->name }}</span>
                                                @endif                                             
                                            </div>
                                        </div>
                                    </div>

                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <div class="flex items-center">
                                                    <!-- Decrement button -->
                                                    <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 h-8"
                                                        onclick="adjustStock({{ $variant->id }}, -1)" title="Decrease by 1">
                                                        <i data-feather="minus" class="w-3 h-3"></i>
                                                    </button>

                                                    <!-- Stock input -->
                                                    <input type="number" id="stock_{{ $variant->id }}"
                                                        class="form-input w-20 text-center border-x-0 rounded-none h-8"
                                                        value="{{ $variant->stock_quantity }}"
                                                        min="0" max="999999"
                                                        data-variant-id="{{ $variant->id }}"
                                                        data-original-stock="{{ $variant->stock_quantity }}"
                                                        onblur="updateVariantStock(this)">
                                                    <!-- Increment button -->
                                                    <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 h-8"
                                                        onclick="adjustStock({{ $variant->id }}, 1)" title="Increase by 1">
                                                        <i data-feather="plus" class="w-3 h-3"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                    @if($variant->stock_quantity == 0)
                                                        <span class="text-red-500">Out of Stock</span>
                                                    @elseif($variant->stock_quantity <= ($product->min_stock_level ?? 5))
                                                        <span class="text-orange-500">Low Stock</span>
                                                    @else
                                                        <span class="text-green-500">In Stock</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1">
                                                <button type="button" class="btn btn-xs btn-outline-danger quick-action-btn"
                                                    onclick="quickSetStock({{ $variant->id }}, 0)" title="Set to 0">
                                                    <i data-feather="x" class="w-3 h-3"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-primary quick-action-btn"
                                                    onclick="quickSetStock({{ $variant->id }}, 5)" title="Set to 5">
                                                    5
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-primary quick-action-btn"
                                                    onclick="quickSetStock({{ $variant->id }}, 10)" title="Set to 10">
                                                    10
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-success quick-action-btn"
                                                    onclick="quickSetStock({{ $variant->id }}, 25)" title="Set to 25">
                                                    25
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-success quick-action-btn"
                                                    onclick="quickSetStock({{ $variant->id }}, 50)" title="Set to 50">
                                                    50
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-success quick-action-btn"
                                                    onclick="quickSetStock({{ $variant->id }}, 100)" title="Set to 100">
                                                    100
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="text-slate-400 text-2xl" data-feather="package"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-800 dark:text-slate-200 mb-2">No Variants Found</h3>
                        <p class="text-slate-500 dark:text-slate-400 mb-4">
                            This product doesn't have any variants yet. Create variants to manage stock.
                        </p>
                        <a href="{{ route('admin.products.variants', $product) }}" class="btn btn-primary">
                            <i data-feather="plus" class="w-4 h-4"></i>
                            Create First Variant
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stock Summary -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="text-green-600" data-feather="check-circle"></i>
                    </div>
                    <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">
                        {{ $product->variants()->where('stock_quantity', '>', 0)->count() }}</h6>
                    <p class="text-sm text-slate-500 dark:text-slate-400">In Stock Variants</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="text-red-600" data-feather="x-circle"></i>
                    </div>
                    <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">
                        {{ $product->variants()->where('stock_quantity', 0)->count() }}</h6>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Out of Stock</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="text-orange-600" data-feather="alert-triangle"></i>
                    </div>
                    <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">
                        {{ $product->variants()->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', ($product->min_stock_level ?? 5))->count() }}
                    </h6>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Low Stock</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Stock Management Ends -->
    @push('styles')
        <style>
            @keyframes slide-in {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .animate-slide-in {
                animation: slide-in 0.3s ease-out;
            }

            .form-input {
                transition: all 0.3s ease;
            }

            .form-input:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .form-input:hover {
                border-color: #9ca3af;
            }

            /* Stock input specific styles */
            .stock-input-group {
                border: 1px solid #d1d5db;
                border-radius: 0.375rem;
                overflow: hidden;
                display: inline-flex;
                background: white;
            }

            .stock-input-group:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .stock-input-group.dark {
                background: #1f2937;
                border-color: #374151;
            }

            .stock-input-group.dark:focus-within {
                border-color: #3b82f6;
            }

            .stock-btn {
                background: #f9fafb;
                border: none;
                padding: 0.5rem 0.75rem;
                cursor: pointer;
                transition: background-color 0.2s;
                color: #6b7280;
                font-size: 0.875rem;
            }

            .stock-btn:hover {
                background: #e5e7eb;
                color: #374151;
            }

            .stock-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .stock-btn.dark {
                background: #374151;
                color: #9ca3af;
            }

            .stock-btn.dark:hover {
                background: #4b5563;
                color: #d1d5db;
            }

            /* Variant row animations */
            .variant-row {
                transition: all 0.3s ease;
            }

            .variant-row.hidden {
                opacity: 0.5;
                transform: scale(0.98);
            }

            /* Checkbox styling */
            .variant-checkbox {
                transform: scale(1.1);
            }

            /* Loading spinner for bulk operations */
            .loading-spinner {
                border: 2px solid #f3f4f6;
                border-top: 2px solid #3b82f6;
                border-radius: 50%;
                width: 16px;
                height: 16px;
                animation: spin 1s linear infinite;
                display: inline-block;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Quick action buttons */
            .quick-action-btn {
                transition: all 0.2s ease;
                position: relative;
            }

            .quick-action-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .quick-action-btn:active {
                transform: translateY(0);
            }

            /* Keyboard shortcut styling */
            kbd {
                font-family: monospace;
                font-size: 0.75rem;
                padding: 0.125rem 0.25rem;
                border-radius: 0.25rem;
                border: 1px solid #d1d5db;
                background: #f9fafb;
                color: #374151;
            }

            .dark kbd {
                border-color: #4b5563;
                background: #374151;
                color: #d1d5db;
            }

            /* Stock status indicators */
            .stock-status {
                position: relative;
            }

            .stock-status::after {
                content: '';
                position: absolute;
                right: 0.5rem;
                top: 50%;
                transform: translateY(-50%);
                width: 0.5rem;
                height: 0.5rem;
                border-radius: 50%;
                background: #10b981;
            }

            .stock-status.out-of-stock::after {
                background: #ef4444;
            }

            .stock-status.low-stock::after {
                background: #f59e0b;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            let updateQueue = [];
            let isUpdating = false;
            const updatingVariants = new Set();

            function updateVariantStock(input) {
                const variantId = input.dataset.variantId;
                let newStock = parseInt(input.value);
                const originalStock = parseInt(input.dataset.originalStock);

                // Validate input - but only show error if user actually entered something invalid
                const inputValue = input.value.toString().trim();
                if (inputValue !== '' && inputValue !== input.dataset.originalStock.toString()) {
                    if (isNaN(newStock) || newStock < 0) {
                        newStock = 0;
                        input.value = 0;
                        showToast('Stock quantity cannot be negative. Set to 0.', 'error');
                    }
                }

                // Only proceed if there's an actual change or if the value is different from original
                if (newStock === originalStock && inputValue === input.dataset.originalStock.toString()) {
                    return; // No change, don't update
                }

                // Check if already updating this variant
                if (updatingVariants.has(variantId)) {
                    showToast('Please wait, stock is being updated...', 'info');
                    return;
                }

                // Visual feedback
                input.classList.add('border-orange-300');
                input.classList.remove('border-slate-300', 'border-red-300', 'border-green-300');

                // Add to update queue
                updateQueue.push({
                    variant_id: variantId,
                    stock_quantity: newStock
                });

                // Debounce updates
                clearTimeout(window.stockUpdateTimeout);
                window.stockUpdateTimeout = setTimeout(() => {
                    processStockUpdates();
                }, 1000);
            }

            async function processStockUpdates() {
                if (isUpdating || updateQueue.length === 0) {
                    return;
                }

                isUpdating = true;
                const updates = [...updateQueue];
                updateQueue = [];

                try {
                    for (const update of updates) {
                        await updateStock(update.variant_id, update.stock_quantity);
                    }
                } catch (error) {
                    console.error('Error updating stock:', error);
                    // Re-add failed updates to queue
                    updateQueue.unshift(...updates);
                } finally {
                    isUpdating = false;
                }
            }

            async function updateStock(variantId, stockQuantity) {
                const input = document.getElementById(`stock_${variantId}`);

                // Mark variant as updating
                updatingVariants.add(variantId);
                input.disabled = true;
                input.classList.add('opacity-50', 'cursor-not-allowed');

                try {
                    const response = await fetch(`{{ route('admin.products.stock.update', $product) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            variant_id: variantId,
                            stock_quantity: stockQuantity
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Update visual feedback
                        input.classList.remove('border-orange-300', 'border-red-300', 'opacity-50', 'cursor-not-allowed');
                        input.classList.add('border-green-300');
                        input.dataset.originalStock = stockQuantity;
                        input.disabled = false;

                        // Update stock status (with small delay to ensure DOM is ready)
                        setTimeout(() => {
                            updateStockStatus(variantId, stockQuantity);
                        }, 100);

                        // Update total stock display
                        updateTotalStock();

                        // Show success message
                        showToast(result.message || 'Stock updated successfully!', 'success');

                        // Reset border after 2 seconds
                        setTimeout(() => {
                            input.classList.remove('border-green-300');
                            input.classList.add('border-slate-300');
                        }, 2000);
                    } else {
                        // Handle error response
                        const errorMessage = result.message || 'Failed to update stock';
                        throw new Error(errorMessage);
                    }
                } catch (error) {
                    console.error('Error updating stock:', error);

                    // Reset to original value
                    const originalStock = input.dataset.originalStock;
                    input.value = originalStock;

                    // Update visual feedback
                    input.classList.remove('border-orange-300', 'border-green-300', 'opacity-50', 'cursor-not-allowed');
                    input.classList.add('border-red-300');
                    input.disabled = false;

                    // Show detailed error message
                    const errorMessage = error.message || 'Failed to update stock. Please try again.';
                    showToast(errorMessage, 'error');

                    // Reset border after 3 seconds
                    setTimeout(() => {
                        input.classList.remove('border-red-300');
                        input.classList.add('border-slate-300');
                    }, 3000);
                } finally {
                    // Remove from updating set
                    updatingVariants.delete(variantId);
                }
            }

            function updateTotalStock() {
                // Recalculate total stock from all inputs
                let total = 0;
                document.querySelectorAll('[data-variant-id]').forEach(input => {
                    total += parseInt(input.value) || 0;
                });

                // Update display if element exists
                const totalStockEl = document.querySelector('.text-2xl.font-bold.text-slate-800');
                if (totalStockEl) {
                    totalStockEl.textContent = total;
                }
            }

            function quickSetStock(variantId, quantity) {
                const input = document.getElementById(`stock_${variantId}`);
                input.value = quantity;

                // Update visual feedback immediately
                const value = parseInt(input.value);
                if (value === 0) {
                    input.classList.add('border-red-300');
                    input.classList.remove('border-green-300', 'border-orange-300');
                } else if (value <= {{ $product->min_stock_level ?? 5 }}) {
                    input.classList.add('border-orange-300');
                    input.classList.remove('border-green-300', 'border-red-300');
                } else {
                    input.classList.add('border-green-300');
                    input.classList.remove('border-orange-300', 'border-red-300');
                }

                // Update stock status immediately (before API call)
                updateStockStatus(variantId, quantity);

                updateVariantStock(input);
            }

            function updateStockStatus(variantId, stockQuantity) {
                try {
                    // Try multiple ways to find the status element
                    let statusElement = null;
                    const input = document.getElementById(`stock_${variantId}`);

                    if (input) {
                        // Method 1: Navigate through the flex container
                        const statusContainer = input.closest('.flex.items-center.gap-4');
                        if (statusContainer) {
                            statusElement = statusContainer.querySelector('.text-right .text-xs');
                        }

                        // Method 2: Fallback - search within the variant row
                        if (!statusElement) {
                            const variantRow = input.closest('.variant-row');
                            if (variantRow) {
                                statusElement = variantRow.querySelector('.text-right .text-xs');
                            }
                        }

                        // Method 3: Ultimate fallback - direct search
                        if (!statusElement) {
                            statusElement = document.querySelector(`#stock_${variantId} + .text-right .text-xs`) ||
                                          document.querySelector(`.variant-row[data-variant-id="${variantId}"] .text-right .text-xs`);
                        }
                    }

                    if (statusElement) {
                        if (stockQuantity == 0) {
                            statusElement.innerHTML = '<span class="text-red-500">Out of Stock</span>';
                        } else if (stockQuantity <= {{ $product->min_stock_level ?? 5 }}) {
                            statusElement.innerHTML = '<span class="text-orange-500">Low Stock</span>';
                        } else {
                            statusElement.innerHTML = '<span class="text-green-500">In Stock</span>';
                        }
                    } else {
                        console.warn(`Could not find status element for variant ${variantId}. Input element:`, input);
                    }
                } catch (error) {
                    console.error('Error updating stock status:', error);
                    // Don't show toast for this internal error as it's not user-facing
                }
            }

            function adjustStock(variantId, change) {
                const input = document.getElementById(`stock_${variantId}`);
                let currentValue = parseInt(input.value) || 0;
                let newValue = currentValue + change;

                // Ensure value doesn't go below 0
                if (newValue < 0) newValue = 0;

                input.value = newValue;

                // Update visual feedback immediately
                const value = parseInt(input.value);
                if (value === 0) {
                    input.classList.add('border-red-300');
                    input.classList.remove('border-green-300', 'border-orange-300');
                } else if (value <= {{ $product->min_stock_level ?? 5 }}) {
                    input.classList.add('border-orange-300');
                    input.classList.remove('border-green-300', 'border-red-300');
                } else {
                    input.classList.add('border-green-300');
                    input.classList.remove('border-orange-300', 'border-red-300');
                }

                // Update stock status immediately (before API call)
                updateStockStatus(variantId, newValue);

                updateVariantStock(input);
            }

            function validateStockInput(input) {
                // This function is kept for potential future use but no longer automatically called
                let value = parseInt(input.value);

                // Only validate if there's an actual value entered by user
                if (input.value.trim() !== '' && input.value !== input.dataset.originalStock) {
                    // Ensure value is not negative
                    if (isNaN(value) || value < 0) {
                        input.value = 0;
                        showToast('Stock quantity cannot be negative', 'error');
                        return false;
                    }
                }

                return true;
            }

            function bulkSetStock(quantity) {
                if (!confirm(`Are you sure you want to set ALL variants to ${quantity}?`)) {
                    return;
                }

                const inputs = document.querySelectorAll('[data-variant-id]');
                let updatedCount = 0;

                inputs.forEach(input => {
                    if (input && input.value !== undefined) {
                        try {
                            input.value = quantity;

                            // Update visual feedback immediately
                            const value = parseInt(input.value);
                            if (value === 0) {
                                input.classList.add('border-red-300');
                                input.classList.remove('border-green-300', 'border-orange-300');
                            } else if (value <= {{ $product->min_stock_level ?? 5 }}) {
                                input.classList.add('border-orange-300');
                                input.classList.remove('border-green-300', 'border-red-300');
                            } else {
                                input.classList.add('border-green-300');
                                input.classList.remove('border-orange-300', 'border-red-300');
                            }

                            // Update stock status immediately (before API call)
                            if (input.dataset && input.dataset.variantId) {
                                updateStockStatus(input.dataset.variantId, quantity);
                            }

                            updateVariantStock(input);
                            updatedCount++;
                        } catch (error) {
                            console.error('Error updating input:', error);
                        }
                    }
                });

                if (updatedCount > 0) {
                    showToast(`Setting ${updatedCount} variants to ${quantity}`, 'info');
                } else {
                    showToast('No variants found to update', 'warning');
                }
            }

            function filterVariants(searchTerm) {
                const rows = document.querySelectorAll('.variant-row');
                const term = searchTerm.toLowerCase();
                let visibleCount = 0;

                rows.forEach(row => {
                    const name = row.dataset.name;
                    const sku = row.dataset.sku;
                    const size = row.dataset.size;
                    const color = row.dataset.color;

                    const matches = name.includes(term) ||
                                   sku.includes(term) ||
                                   size.includes(term) ||
                                   color.includes(term);

                    if (matches || term === '') {
                        row.style.display = 'block';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update select all checkbox
                updateSelectAllState();
            }

            function toggleSelectAll() {
                const selectAllCheckbox = document.getElementById('select-all-variants');
                const visibleCheckboxes = document.querySelectorAll('.variant-row[style*="block"] .variant-checkbox, .variant-row:not([style*="none"]) .variant-checkbox');
                const isChecked = selectAllCheckbox.checked;

                visibleCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });

                updateBulkControls();
            }

            function updateSelectAllState() {
                const visibleCheckboxes = document.querySelectorAll('.variant-row[style*="block"] .variant-checkbox, .variant-row:not([style*="none"]) .variant-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.variant-row[style*="block"] .variant-checkbox:checked, .variant-row:not([style*="none"]) .variant-checkbox:checked');
                const selectAllCheckbox = document.getElementById('select-all-variants');

                if (visibleCheckboxes.length === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedCheckboxes.length === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedCheckboxes.length === visibleCheckboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                }
            }

            function updateBulkControls() {
                const checkedCheckboxes = document.querySelectorAll('.variant-checkbox:checked');
                const bulkValueInput = document.getElementById('bulk-stock-value');
                const bulkUpdateBtn = document.getElementById('bulk-update-btn');
                const selectedCountEl = document.getElementById('selected-count');
                const totalCountEl = document.getElementById('total-count');

                // Update counts
                selectedCountEl.textContent = checkedCheckboxes.length;
                totalCountEl.textContent = document.querySelectorAll('.variant-checkbox').length;

                if (checkedCheckboxes.length === 0) {
                    bulkValueInput.disabled = true;
                    bulkUpdateBtn.disabled = true;
                    bulkValueInput.value = '';
                } else {
                    bulkValueInput.disabled = false;
                    bulkUpdateBtn.disabled = false;
                    if (bulkValueInput.value === '') {
                        bulkValueInput.focus();
                    }
                }

                updateSelectAllState();
            }

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl+A to select all visible
                if (e.ctrlKey && e.key === 'a') {
                    e.preventDefault();
                    toggleSelectAll();
                }

                // Escape to clear selection
                if (e.key === 'Escape') {
                    document.querySelectorAll('.variant-checkbox:checked').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateBulkControls();
                }
            });

            async function bulkUpdateSelected() {
                const checkedCheckboxes = document.querySelectorAll('.variant-checkbox:checked');
                const bulkValueInput = document.getElementById('bulk-stock-value');
                const bulkValue = parseInt(bulkValueInput ? bulkValueInput.value : '0');

                if (checkedCheckboxes.length === 0) {
                    showToast('No variants selected', 'warning');
                    return;
                }

                if (isNaN(bulkValue) || bulkValue < 0) {
                    showToast('Please enter a valid stock quantity', 'error');
                    return;
                }

                if (!confirm(`Update ${checkedCheckboxes.length} selected variants to ${bulkValue}?`)) {
                    return;
                }

                const bulkUpdateBtn = document.getElementById('bulk-update-btn');
                if (bulkUpdateBtn) {
                    bulkUpdateBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 animate-spin"></i> Updating...';
                    bulkUpdateBtn.disabled = true;
                }

                let successCount = 0;
                let errorCount = 0;

                for (const checkbox of checkedCheckboxes) {
                    const variantId = checkbox.value;
                    const input = document.getElementById(`stock_${variantId}`);

                    if (input) {
                        try {
                            input.value = bulkValue;

                            // Update visual feedback immediately
                            const value = parseInt(input.value);
                            if (value === 0) {
                                input.classList.add('border-red-300');
                                input.classList.remove('border-green-300', 'border-orange-300');
                            } else if (value <= {{ $product->min_stock_level ?? 5 }}) {
                                input.classList.add('border-orange-300');
                                input.classList.remove('border-green-300', 'border-red-300');
                            } else {
                                input.classList.add('border-green-300');
                                input.classList.remove('border-orange-300', 'border-red-300');
                            }

                            // Update stock status immediately (before API call)
                            updateStockStatus(variantId, bulkValue);

                            await updateStock(variantId, bulkValue);
                            successCount++;
                        } catch (error) {
                            console.error(`Failed to update variant ${variantId}:`, error);
                            errorCount++;
                        }
                    }
                }

                // Reset button
                if (bulkUpdateBtn) {
                    bulkUpdateBtn.innerHTML = '<i data-feather="refresh-cw" class="w-4 h-4"></i> Update Selected';
                    bulkUpdateBtn.disabled = false;
                }

                // Update bulk controls
                updateBulkControls();

                // Show result
                if (successCount > 0) {
                    showToast(`Successfully updated ${successCount} variants${errorCount > 0 ? `, ${errorCount} failed` : ''}`, successCount === checkedCheckboxes.length ? 'success' : 'warning');
                } else {
                    showToast('Failed to update variants', 'error');
                }

                // Clear bulk value
                if (bulkValueInput) {
                    bulkValueInput.value = '';
                }
            }

            function showToast(message, type = 'info') {
                // Create toast container if it doesn't exist
                let toastContainer = document.getElementById('toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.id = 'toast-container';
                    toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
                    document.body.appendChild(toastContainer);
                }

                // Create toast element
                const toast = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
                const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info';

                toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 min-w-[300px] max-w-[500px] animate-slide-in`;
                toast.innerHTML = `
                <i data-feather="${icon}" class="w-5 h-5 flex-shrink-0"></i>
                <span class="flex-1">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 flex-shrink-0">
                    <i data-feather="x" class="w-4 h-4"></i>
                </button>
            `;

                toastContainer.appendChild(toast);

                // Initialize Feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }

                // Auto-remove after duration based on type
                const duration = type === 'error' ? 5000 : 3000;
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'all 0.3s ease-out';
                    setTimeout(() => toast.remove(), 300);
                }, duration);
            }

            // Auto-save functionality
            document.addEventListener('DOMContentLoaded', function () {
                // Mark all inputs as unchanged initially
                document.querySelectorAll('[data-variant-id]').forEach(input => {
                    input.classList.add('border-slate-300');
                });

                // Initialize bulk controls
                updateBulkControls();

                // Initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }

                // Set initial border colors based on current values without validation
                document.querySelectorAll('[data-variant-id]').forEach(input => {
                    const value = parseInt(input.value);
                    if (!isNaN(value)) {
                        if (value === 0) {
                            input.classList.add('border-red-300');
                        } else if (value <= {{ $product->min_stock_level ?? 5 }}) {
                            input.classList.add('border-orange-300');
                        } else {
                            input.classList.add('border-green-300');
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
