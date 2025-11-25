<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Show products for the selected category.
     */
    public function categoryProducts(Request $request, string $slug)
    {
        try {
            $category = Category::where('slug', $slug)
                ->where('is_active', true)
                ->first();

            if (! $category) {
                return redirect()->route('home')->with('error', 'Category not found.');
            }

            $selectedColorIds = collect($request->input('colors', []))
                ->filter(fn ($id) => is_numeric($id))
                ->map(fn ($id) => (int) $id)
                ->values();

            $selectedSizeIds = collect($request->input('sizes', []))
                ->filter(fn ($id) => is_numeric($id))
                ->map(fn ($id) => (int) $id)
                ->values();

            $priceMin = $request->filled('price_min') && is_numeric($request->input('price_min'))
                ? (float) $request->input('price_min')
                : null;

            $priceMax = $request->filled('price_max') && is_numeric($request->input('price_max'))
                ? (float) $request->input('price_max')
                : null;

            $productsQuery = Product::with([
                'brand',
                'images' => function ($query) {
                    $query->orderBy('sort_order');
                },
            ])
                ->where('category_id', $category->id)
                ->where('is_active', true);

            if ($selectedColorIds->isNotEmpty() || $selectedSizeIds->isNotEmpty()) {
                $productsQuery->whereHas('variants', function ($variantQuery) use ($selectedColorIds, $selectedSizeIds) {
                    $variantQuery->where('is_active', true);

                    if ($selectedColorIds->isNotEmpty()) {
                        $variantQuery->whereIn('color_id', $selectedColorIds);
                    }

                    if ($selectedSizeIds->isNotEmpty()) {
                        $variantQuery->whereIn('size_id', $selectedSizeIds);
                    }
                });
            }

            $this->applyPriceFilter($productsQuery, $priceMin, $priceMax);

            $products = $productsQuery
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $priceStats = Product::where('category_id', $category->id)
                ->where('is_active', true)
                ->selectRaw(
                    'MIN(' . $this->finalPriceExpression() . ') as min_price, ' .
                    'MAX(' . $this->finalPriceExpression() . ') as max_price'
                )
                ->first();
     
            $sizes = Size::active()
                ->whereHas('variants', function ($variantQuery) use ($category) {
                    $variantQuery->where('is_active', true)
                        ->whereHas('product', function ($productQuery) use ($category) {
                            $productQuery->where('category_id', $category->id)
                                ->where('is_active', true);
                        });
                })
                ->ordered()
                ->get(['id', 'name']);

            $priceRange = [
                'min' => $priceStats?->min_price !== null ? (float) $priceStats->min_price : 0.0,
                'max' => $priceStats?->max_price !== null ? (float) $priceStats->max_price : 30000.0,
            ];

            $appliedFilters = [
                'price' => [
                    'min' => $priceMin,
                    'max' => $priceMax,
                ],
                'sizes' => $selectedSizeIds,
            ];

            return view('product.category', compact(
                'category',
                'products',
                'sizes',
                'priceRange',
                'appliedFilters'
            ));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('home')->with('error', 'Unable to load category products at the moment.');
        }
    }

    /**
     * Display the specified subcategory with its products
     */
    public function show(Request $request, Category $category, Subcategory $subcategory)
    {
        // Ensure both category and subcategory are active
        if (!$category->is_active || !$subcategory->is_active) {
            abort(404, 'Category or subcategory not found');
        }

        // Ensure subcategory belongs to the category
        if ($subcategory->category_id !== $category->id) {
            abort(404, 'Subcategory not found in this category');
        }

        // Get subcategory with relationships
        $subcategory->load([
            'childCategories' => function ($query) {
                $query->where('is_active', true)->orderBy('name');
            }
        ]);

        $selectedColorIds = collect($request->input('colors', []))
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->values();

        $selectedSizeIds = collect($request->input('sizes', []))
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->values();

        $priceMin = $request->filled('price_min') && is_numeric($request->input('price_min'))
            ? (float) $request->input('price_min')
            : null;

        $priceMax = $request->filled('price_max') && is_numeric($request->input('price_max'))
            ? (float) $request->input('price_max')
            : null;

        $childCategorySlug = $request->input('child_category');
        $activeChildCategory = null;

        if ($childCategorySlug) {
            $activeChildCategory = $subcategory->childCategories
                ->firstWhere('slug', $childCategorySlug);
        }

        $baseQuery = Product::query()
            ->where('category_id', $category->id)
            ->where('subcategory_id', $subcategory->id)
            ->where('is_active', true);

        if ($activeChildCategory) {
            $baseQuery->where('child_category_id', $activeChildCategory->id);
        }

        $productsQuery = (clone $baseQuery)->with([
            'brand',
            'images' => function ($query) {
                $query->orderBy('sort_order');
            },
            'category',
            'variants',
        ]);

        if ($selectedColorIds->isNotEmpty() || $selectedSizeIds->isNotEmpty()) {
            $productsQuery->whereHas('variants', function ($variantQuery) use ($selectedColorIds, $selectedSizeIds) {
                $variantQuery->where('is_active', true);

                if ($selectedColorIds->isNotEmpty()) {
                    $variantQuery->whereIn('color_id', $selectedColorIds);
                }

                if ($selectedSizeIds->isNotEmpty()) {
                    $variantQuery->whereIn('size_id', $selectedSizeIds);
                }
            });
        }

        $this->applyPriceFilter($productsQuery, $priceMin, $priceMax);

        $products = $productsQuery
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $priceStats = (clone $baseQuery)
            ->selectRaw(
                'MIN(' . $this->finalPriceExpression() . ') as min_price, ' .
                'MAX(' . $this->finalPriceExpression() . ') as max_price'
            )
            ->first();      

        $sizes = Size::active()
            ->whereHas('variants', function ($variantQuery) use ($category, $subcategory, $activeChildCategory) {
                $variantQuery->where('is_active', true)
                    ->whereHas('product', function ($productQuery) use ($category, $subcategory, $activeChildCategory) {
                        $productQuery->where('category_id', $category->id)
                            ->where('subcategory_id', $subcategory->id)
                            ->where('is_active', true);

                        if ($activeChildCategory) {
                            $productQuery->where('child_category_id', $activeChildCategory->id);
                        }
                    });
            })
            ->ordered()
            ->get(['id', 'name']);

        $colors = Color::active()
            ->where(function ($colorQuery) use ($category, $subcategory, $activeChildCategory) {
                $colorQuery->whereHas('products', function ($productQuery) use ($category, $subcategory, $activeChildCategory) {
                    $productQuery->where('category_id', $category->id)
                        ->where('subcategory_id', $subcategory->id)
                        ->where('is_active', true);

                    if ($activeChildCategory) {
                        $productQuery->where('child_category_id', $activeChildCategory->id);
                    }
                });
            })
            ->ordered()
            ->get(['id', 'name', 'code', 'hex_code']);

        $priceRange = [
            'min' => $priceStats?->min_price !== null ? (float) $priceStats->min_price : 0.0,
            'max' => $priceStats?->max_price !== null ? (float) $priceStats->max_price : 30000.0,
        ];

        $appliedFilters = [
            'price' => [
                'min' => $priceMin,
                'max' => $priceMax,
            ],
            'colors' => $selectedColorIds,
            'sizes' => $selectedSizeIds,
        ];

        return view('frontend.categories.subcategory', compact(
            'category',
            'subcategory',
            'products',
            'colors',
            'sizes',
            'priceRange',
            'appliedFilters'
        ));
    }

        private function applyPriceFilter($query, ?float $priceMin, ?float $priceMax): void
        {
            if (is_null($priceMin) && is_null($priceMax)) {
                return;
            }

            $expression = $this->finalPriceExpression();

            $query->where(function ($priceQuery) use ($priceMin, $priceMax, $expression) {
                if (! is_null($priceMin)) {
                    $priceQuery->whereRaw("{$expression} >= ?", [$priceMin]);
                }

                if (! is_null($priceMax)) {
                    $priceQuery->whereRaw("{$expression} <= ?", [$priceMax]);
                }
            });
        }

        private function finalPriceExpression(): string
        {
            return 'CAST(CASE WHEN sale_price IS NOT NULL AND sale_price > 0 THEN sale_price ELSE price END AS DECIMAL(10,2))';
        }
}
