@props([
    'action',
    'colors' => collect(),
    'sizes' => collect(),
    'priceRange' => ['min' => null, 'max' => null],
    'applied' => [
        'price' => ['min' => null, 'max' => null],
        'colors' => [],
        'sizes' => [],
    ],
])

@php
    $appliedColorIds = collect($applied['colors'] ?? [])->filter()->map(fn ($id) => (int) $id);
    $appliedSizeIds = collect($applied['sizes'] ?? [])->filter()->map(fn ($id) => (int) $id);
    $activeColorCount = $appliedColorIds->count();
    $activeSizeCount = $appliedSizeIds->count();
    $hasPriceFilter = filled($applied['price']['min'] ?? null) || filled($applied['price']['max'] ?? null);
    $activeFilterTotal = $activeColorCount + $activeSizeCount + ($hasPriceFilter ? 1 : 0);
    $rangeMin = $priceRange['min'] ?? 0;
    $rangeMax = $priceRange['max'] ?? 30000;
    $minPlaceholder = number_format((float) $rangeMin);
    $maxPlaceholder = number_format((float) $rangeMax);
@endphp

<div class="bg-white border border-slate-100 rounded-2xl shadow-sm flex flex-col h-full" data-filter-card>
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            <h2 class="text-base font-semibold text-slate-900">Filters</h2>
            @if($activeFilterTotal > 0)
                <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">{{ $activeFilterTotal }}</span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            @if($activeFilterTotal > 0)
                <a href="{{ $action }}" class="text-xs font-medium text-slate-500 hover:text-slate-900">
                    Clear all
                </a>
            @endif
            <button type="button" class="lg:hidden inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:text-slate-900" data-mobile-filter-close aria-label="Close filters">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <form id="category-filter-form" action="{{ $action }}" method="GET" class="px-5 py-4 space-y-6 flex flex-col h-full overflow-y-auto">
        @foreach(request()->except(['page', 'price_min', 'price_max', 'colors', 'sizes']) as $name => $value)
            @if(is_array($value))
                @foreach($value as $nestedValue)
                    <input type="hidden" name="{{ $name }}[]" value="{{ $nestedValue }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endif
        @endforeach

        {{-- price filter --}}
        <section class="space-y-3 border border-slate-100 rounded-xl p-4" data-filter-section>
            <button type="button" data-filter-section-toggle="price" class="flex w-full items-center justify-between text-left">
                <span class="text-sm font-semibold text-slate-900">Price Range</span>
                <svg class="h-4 w-4 text-slate-400 transition-transform" data-filter-chevron="price" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <div class="space-y-3" data-filter-section-content="price">
                <label class="sr-only">Price range</label>
                <div class="px-2">
                    <div id="price-range-slider" class="mb-4"></div>
                </div>
                <input type="hidden" name="price_min" value="{{ $applied['price']['min'] ?? $rangeMin }}" data-price-min>
                <input type="hidden" name="price_max" value="{{ $applied['price']['max'] ?? $rangeMax }}" data-price-max>
            </div>
        </section>


        <section class="space-y-3 border border-slate-100 rounded-xl p-4" data-filter-section>
            <button type="button" data-filter-section-toggle="color" class="flex w-full items-center justify-between text-left">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-slate-900">Color</span>
                    @if($activeColorCount > 0)
                        <span class="inline-flex items-center rounded-full bg-slate-900/5 px-2 py-0.5 text-[10px] font-medium text-slate-700">{{ $activeColorCount }}</span>
                    @endif
                </div>
                <svg class="h-4 w-4 text-slate-400 transition-transform" data-filter-chevron="color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <div class="space-y-2 max-h-56 overflow-y-auto pr-1" data-filter-section-content="color">
                @forelse($colors as $color)
                    @php
                        $isChecked = $appliedColorIds->contains($color->id);
                        $swatch = $color->hex_code ?: $color->code;
                    @endphp
                    <label class="flex items-center gap-3 rounded-lg px-2 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        <input type="checkbox" name="colors[]" value="{{ $color->id }}" @checked($isChecked) class="h-4 w-4 rounded border border-slate-300 text-amber-600 focus:ring-amber-200" />
                        <span class="h-5 w-5 rounded-full border border-slate-200" style="background-color: {{ $swatch }}"></span>
                        <span class="flex-1 text-slate-700">{{ $color->name }}</span>
                    </label>
                @empty
                    <p class="text-xs text-slate-400">No colors available for this category.</p>
                @endforelse
            </div>
        </section>

        <section class="space-y-3 border border-slate-100 rounded-xl p-4" data-filter-section>
            <button type="button" data-filter-section-toggle="size" class="flex w-full items-center justify-between text-left">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-slate-900">Product Size</span>
                    @if($activeSizeCount > 0)
                        <span class="inline-flex items-center rounded-full bg-slate-900/5 px-2 py-0.5 text-[10px] font-medium text-slate-700">{{ $activeSizeCount }}</span>
                    @endif
                </div>
                <svg class="h-4 w-4 text-slate-400 transition-transform" data-filter-chevron="size" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <div class="flex flex-wrap gap-2" data-filter-section-content="size">
                @forelse($sizes as $size)
                    @php
                        $isChecked = $appliedSizeIds->contains($size->id);
                    @endphp
                    <label class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:border-slate-400">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}" @checked($isChecked) class="h-4 w-4 rounded border border-slate-300 text-amber-600 focus:ring-amber-200" />
                        <span>{{ $size->name }}</span>
                    </label>
                @empty
                    <p class="w-full text-xs text-slate-400">No size information available.</p>
                @endforelse
            </div>
        </section>

        <div class="pt-2 mt-auto">
            <button type="submit" class="w-full rounded-lg bg-slate-900 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Apply Filters
            </button>
        </div>
    </form>
</div>

@once
    @push('styles')
        <style>
            .mobile-filter-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                z-index: 40;
                display: none;
            }

            .mobile-filter-backdrop.is-active {
                display: block;
            }

            .mobile-filter-panel.is-open {
                display: block;
                position: fixed;
                inset: 0;
                right: 0;
                width: 100%;
                max-width: 100%;
                margin-left: auto;
                background: #fff;
                z-index: 50;
                overflow-y: auto;
                box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
                padding: 0;
                box-sizing: border-box;
            }

            .mobile-filter-panel.is-open > div:first-child {
                max-height: none;
                height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }

            @media (min-width: 480px) {
                .mobile-filter-panel.is-open {
                    max-width: 22rem;
                    padding: 1.25rem;
                }

                .mobile-filter-panel.is-open > div:first-child {
                    max-height: calc(100vh - 2.5rem);
                    height: auto;
                    border-radius: 1.5rem;
                    box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
                }
            }

            @media (min-width: 1024px) {
                .mobile-filter-backdrop {
                    display: none !important;
                }

                .mobile-filter-panel.is-open {
                    position: static;
                    max-width: none;
                    box-shadow: none;
                    overflow: visible;
                }
            }

            /* Custom noUiSlider styling */
            .noUi-target {
                background: #f1f5f9;
                border-radius: 9999px;
                border: none;
                box-shadow: none;
                height: 8px;
            }

            .noUi-base {
                height: 8px;
            }

            .noUi-connects {
                border-radius: 9999px;
                overflow: hidden;
            }

            .noUi-connect {
                background: #f59e0b;
            }

            .noUi-handle {
                background: white;
                border: 2px solid #f59e0b;
                border-radius: 50%;
                box-shadow: none;
                cursor: pointer;
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.1s;
                position: relative;
            }

            .noUi-handle:hover {
                transform: scale(1.1);
            }

            .noUi-handle:before,
            .noUi-handle:after {
                display: none;
            }

            .noUi-horizontal .noUi-handle {
                top: -12px;
                right: -16px;
            }

            .noUi-handle .slider-handle-value {
                font-size: 10px;
                font-weight: 600;
                color: #1e293b;
                white-space: nowrap;
                pointer-events: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function loadNoUiSlider() {
                return new Promise((resolve, reject) => {
                    if (window.noUiSlider) {
                        resolve(window.noUiSlider);
                        return;
                    }

                    const script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js';
                    script.onload = () => resolve(window.noUiSlider);
                    script.onerror = reject;
                    document.head.appendChild(script);

                    const style = document.createElement('link');
                    style.rel = 'stylesheet';
                    style.href = 'https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css';
                    document.head.appendChild(style);
                });
            }

            document.addEventListener('DOMContentLoaded', async () => {
                const form = document.getElementById('category-filter-form');
                const toggles = document.querySelectorAll('[data-filter-section-toggle]');
                const mobilePanel = document.querySelector('[data-mobile-filter-panel]');
                const mobileBackdrop = document.querySelector('[data-mobile-filter-backdrop]');
                const mobileOpenButtons = document.querySelectorAll('[data-mobile-filter-open]');
                const mobileCloseButtons = document.querySelectorAll('[data-mobile-filter-close]');
                let originalBodyOverflow = null;

                const openMobileFilters = () => {
                    if (!mobilePanel) {
                        return;
                    }

                    mobilePanel.classList.add('is-open');
                    mobilePanel.classList.remove('hidden');

                    if (mobileBackdrop) {
                        mobileBackdrop.classList.add('is-active');
                        mobileBackdrop.classList.remove('hidden');
                    }

                    if (originalBodyOverflow === null) {
                        originalBodyOverflow = document.body.style.overflow;
                    }
                    document.body.style.overflow = 'hidden';
                };

                const closeMobileFilters = () => {
                    if (!mobilePanel) {
                        return;
                    }

                    mobilePanel.classList.remove('is-open');
                    mobilePanel.classList.add('hidden');

                    if (mobileBackdrop) {
                        mobileBackdrop.classList.remove('is-active');
                        mobileBackdrop.classList.add('hidden');
                    }

                    if (originalBodyOverflow !== null) {
                        document.body.style.overflow = originalBodyOverflow;
                        originalBodyOverflow = null;
                    }
                };

                mobileOpenButtons.forEach((button) => {
                    button.addEventListener('click', openMobileFilters);
                });

                mobileCloseButtons.forEach((button) => {
                    button.addEventListener('click', closeMobileFilters);
                });

                if (mobileBackdrop) {
                    mobileBackdrop.addEventListener('click', closeMobileFilters);
                }

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && mobilePanel?.classList.contains('is-open')) {
                        closeMobileFilters();
                    }
                });

                const lgMediaQuery = window.matchMedia('(min-width: 1024px)');
                lgMediaQuery.addEventListener('change', (event) => {
                    if (event.matches) {
                        closeMobileFilters();
                    }
                });

                try {
                    // Wait for noUiSlider to load
                    const noUiSlider = await loadNoUiSlider();

                    const sliderElement = document.getElementById('price-range-slider');
                    if (sliderElement) {
                        // Initialize range slider
                        noUiSlider.create(sliderElement, {
                            start: [{{ $applied['price']['min'] ?? $rangeMin }}, {{ $applied['price']['max'] ?? $rangeMax }}],
                            connect: true,
                            range: {
                                'min': {{ $rangeMin }},
                                'max': {{ $rangeMax }}
                            },
                            format: {
                                to: function (value) {
                                    return Math.round(value);
                                },
                                from: function (value) {
                                    return Number(value);
                                }
                            }
                        });

                        const handles = sliderElement.querySelectorAll('.noUi-handle');
                        const minInput = document.querySelector('[data-price-min]');
                        const maxInput = document.querySelector('[data-price-max]');
                        handles.forEach((handle) => {
                            const valueEl = document.createElement('span');
                            valueEl.className = 'slider-handle-value';
                            handle.innerHTML = '';
                            handle.appendChild(valueEl);
                        });

                        // Handle slider changes
                        sliderElement.noUiSlider.on('update', function (values) {
                            const [min, max] = values.map((value) => Math.round(value));
                            if (minInput) {
                                minInput.value = min;
                            }
                            if (maxInput) {
                                maxInput.value = max;
                            }

                            if (handles[0]) {
                                handles[0].firstChild.textContent = '৳' + min.toLocaleString();
                            }

                            if (handles[1]) {
                                handles[1].firstChild.textContent = '৳' + max.toLocaleString();
                            }
                        });

                        // Submit form when user stops dragging
                        sliderElement.noUiSlider.on('end', function () {
                            clearTimeout(window.priceDebounceTimer);
                            window.priceDebounceTimer = setTimeout(() => form.submit(), 500);
                        });
                    }
                } catch (error) {
                    console.error('Failed to load noUiSlider:', error);
                }

                toggles.forEach((button) => {
                    const sectionName = button.getAttribute('data-filter-section-toggle');
                    const content = document.querySelector('[data-filter-section-content="' + sectionName + '"]');
                    const chevron = document.querySelector('[data-filter-chevron="' + sectionName + '"]');

                    if (!content || !chevron) {
                        return;
                    }

                    button.addEventListener('click', () => {
                        content.classList.toggle('hidden');
                        chevron.classList.toggle('-rotate-180');
                    });
                });

                if (form) {
                    let debounceTimer;
                    form.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
                        checkbox.addEventListener('change', () => {
                            clearTimeout(debounceTimer);
                            debounceTimer = setTimeout(() => form.submit(), 250);
                        });
                    });
                }
            });
        </script>
    @endpush
@endonce
