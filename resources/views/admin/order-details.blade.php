<x-admin-layout title="Order Details">
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Order Details #{{ $order->order_number }}</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.orders.index') }}">Orders</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">#{{ $order->order_number }}</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Order Summary -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="w-[5%] uppercase">#</th>
                                    <th class="w-[60%] uppercase">Product</th>
                                    <th class="w-[15%] text-right uppercase">Price</th>
                                    <th class="w-[10%] text-center uppercase">Qty</th>
                                    <th class="w-[20%] text-right uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->images->count() > 0)
                                            <img src="{{ asset($item->product->main_image) }}"
                                                alt="{{ $item->name }}"
                                                class="h-12 w-12 rounded border object-cover">
                                            @endif
                                            <div>
                                                <h6 class="font-medium text-slate-700">{{ $item->name }}</h6>
                                                @if($item->variant)
                                                <p class="text-xs text-slate-500">
                                                    {{ $item->variant->color->name ?? '' }}
                                                    {{ $item->variant->size->name ?? '' }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes || $order->admin_notes)
            <div class="card mt-6">
                <div class="card-header">
                    <h5>Order Notes</h5>
                </div>
                <div class="card-body">
                    @if($order->notes)
                    <div class="mb-4">
                        <h6>Customer Note:</h6>
                        <p class="mt-1">{{ $order->notes }}</p>
                    </div>
                    @endif

                    @if($order->admin_notes)
                    <div>
                        <h6>Admin Note:</h6>
                        <p class="mt-1">{{ $order->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Order Details Sidebar -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-center justify-between">
                        <span>Order Status:</span>
                        <span class="font-medium">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full {{ $statusColors[strtolower($order->status)] ?? 'bg-slate-500' }}"></span>
                                <span class="capitalize">{{ $order->status }}</span>
                            </span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Payment Status:</span>
                        <span class="font-medium">
                            @if($order->payment_status === 'paid')
                                <span class="text-success-600">Paid</span>
                            @else
                                <span class="text-danger-600">Unpaid</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Order Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @if($order->shipped_at)
                    <div class="flex items-center justify-between">
                        <span>Shipped On:</span>
                        <span class="font-medium">{{ $order->shipped_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @endif
                    @if($order->delivered_at)
                    <div class="flex items-center justify-between">
                        <span>Delivered On:</span>
                        <span class="font-medium">{{ $order->delivered_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card">
                <div class="card-header">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-center gap-3">
                        @if($order->customer && $order->customer->avatar)
                            <img src="{{ asset('storage/' . $order->customer->avatar) }}"
                                alt="{{ $order->customer->name }}"
                                class="h-10 w-10 rounded-full object-cover">
                        @endif
                        <div>
                            <h6>{{ $order->customer->name ?? 'Guest' }}</h6>
                            @if($order->customer)
                                <p>{{ $order->customer->email }}</p>
                            @endif
                        </div>
                    </div>

                    @if($order->shippingAddress)
                    <div class="mt-4">
                        <h6>Shipping Address</h6>
                        <address class="mt-1 not-italic">
                            {{ $order->shippingAddress->address_line_1 }}<br>
                            @if($order->shippingAddress->address_line_2)
                                {{ $order->shippingAddress->address_line_2 }}<br>
                            @endif
                            {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}<br>
                                            {{ $order->shippingAddress->postal_code }}, {{ $order->shippingAddress->country->name ?? $order->shippingAddress->country_code }}
                            <br>
                            <span class="mt-1 block">
                                <span class="font-medium">Phone:</span> {{ $order->shippingAddress->phone }}
                            </span>
                        </address>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Total -->
            <div class="card">
                <div class="card-header">
                    <h5>Order Total</h5>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex items-center justify-between">
                        <span>Subtotal:</span>
                        <span class="font-medium">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex items-center justify-between">
                        <span>Discount:</span>
                        <span class="font-medium text-danger-600">-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span>Shipping:</span>
                        <span class="font-medium">${{ number_format($order->shipping_amount, 2) }}</span>
                    </div>
                    <div class="border-t border-slate-200 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Total:</span>
                            <span class="text-lg font-bold text-primary-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="relative" id="order-actions-dropdown">
                <button id="order-actions-button" class="btn btn-primary w-full">
                    <span>Order Actions</span>
                    <i data-feather="chevron-down" class="h-4 w-4"></i>
                </button>

                <div id="order-actions-menu" class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="order-actions-button" tabindex="-1">
                    <div class="py-1" role="none">
                        @if($order->status !== 'cancelled' && $order->status !== 'refunded')
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm  hover:bg-slate-100" role="menuitem">
                                    <i data-feather="check-circle" class="h-4 w-4"></i>
                                    <span>Mark as Processing</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="shipped">
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm" role="menuitem">
                                    <i data-feather="truck" class="h-4 w-4"></i>
                                    <span>Mark as Shipped</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm" role="menuitem">
                                    <i data-feather="check" class="h-4 w-4"></i>
                                    <span>Mark as Delivered</span>
                                </button>
                            </form>
                            <div class="border-t border-slate-200 my-1"></div>
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm text-danger-600 hover:bg-slate-100" role="menuitem" onclick="return confirm('Are you sure you want to cancel this order?')">
                                    <i data-feather="x" class="h-4 w-4"></i>
                                    <span>Cancel Order</span>
                                </button>
                            </form>
                        @endif
                        <div class="border-t border-slate-200 my-1"></div>
                        <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm" role="menuitem">
                            <i data-feather="printer" class="h-4 w-4"></i>
                            <span>Print Invoice</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdown = document.getElementById('order-actions-dropdown');
                const button = document.getElementById('order-actions-button');
                const menu = document.getElementById('order-actions-menu');

                button.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    if (!dropdown.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
