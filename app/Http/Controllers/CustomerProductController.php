<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerProductController extends Controller
{
    /**
     * Show product page with dynamic data.
     */
    public function show($slug = null)
    {
        // If no slug provided, redirect to home
        if (! $slug) {
            return redirect()->route('home');
        }

        // Find product by slug
        $product = Product::with([
            'category',
            'subcategory',
            'childCategory',
            'brand',
            'images'   => function ($query) {
                $query->ordered();
            },
             'variants' => function ($query) {
                 $query->with(['size']);
             },
            'reviews'  => function ($query) {
                $query->with('customer')->latest()->limit(10);
            },
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        // If product not found, redirect to home
        if (! $product) {
            return redirect()->route('home')->with('error', 'Product not found');
        }

        // Update view count
        $product->increment('view_count');

        return view('product.show', compact('product'));
    }

    /**
     * Get product data for AJAX requests.
     */
    public function getProductData($id): JsonResponse
    {
        try {
            $product = Product::with([
                'category',
                'subcategory',
                'childCategory',
                'brand',
                'images'   => function ($query) {
                    $query->ordered();
                },
                'variants' => function ($query) {
                    $query->with(['size'])->active();
                },
                'reviews'  => function ($query) {
                    $query->with('customer')->latest()->limit(10);
                },
            ])
                ->where('id', $id)
                ->where('is_active', true)
                ->first();

            if (! $product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Update view count
            $product->increment('view_count');

            return response()->json($product);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load product data'], 500);
        }
    }

    /**
     * Show all products page.
     */
    public function index(Request $request)
    {
        $query = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true);

        // Apply filters if needed
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort options
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'rating':
                // For now, order by view_count as proxy for popularity
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Process products with calculated values
        $processedProducts = $products->getCollection()->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Replace the collection
        $products->setCollection($processedProducts);

        return view('products.index', compact('products'));
    }

    /**
     * Show featured products page.
     */
    public function featured(Request $request)
    {
        $query = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where('is_featured', true);

        // Apply additional filters if needed
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort options
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'rating':
                // For now, order by view_count as proxy for popularity
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Process products with calculated values
        $processedProducts = $products->getCollection()->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Replace the collection
        $products->setCollection($processedProducts);

        return view('products.featured', compact('products'));
    }

    /**
     * Show popular products page (most ordered items).
     */
    public function popular(Request $request)
    {
        // Get products ordered by sales count (most popular first)
        $query = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where('sales_count', '>', 0) // Only products that have been sold
            ->orderBy('sales_count', 'desc');

        // Apply additional filters if needed
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Additional sort options (default is by sales_count)
        $sortBy = $request->get('sort', 'sales_count');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'created_at':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                // For now, order by view_count as proxy for popularity
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->orderBy('sales_count', 'desc');
        }

        $products = $query->paginate(12);

        // Process products with calculated values
        $processedProducts = $products->getCollection()->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Replace the collection
        $products->setCollection($processedProducts);

        return view('products.popular', compact('products'));
    }

    /**
     * Show new arrivals page.
     */
    public function newArrivals(Request $request)
    {
        $query = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where('created_at', '>=', now()->subDays(30)) // Products from last 30 days
            ->orderBy('created_at', 'desc');

        // Apply additional filters if needed
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort options
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'rating':
                // For now, order by view_count as proxy for popularity
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Process products with calculated values
        $processedProducts = $products->getCollection()->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Replace the collection
        $products->setCollection($processedProducts);

        return view('products.new-arrivals', compact('products'));
    }

    /**
     * Search for products by name or SKU.
     */
    public function search(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if ($term === '') {
            return redirect()->back()->with('error', 'Please enter a product name or SKU.');
        }

        $products = Product::query()
            ->with(['category', 'brand', 'images'])
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                      ->orWhere('sku', 'like', "%{$term}%");
            })
            ->orderByDesc('sales_count')
            ->paginate(24)
            ->withQueryString();

        return view('product.search', [
            'products' => $products,
            'term' => $term,
        ]);
    }

    /**
     * Provide lightweight product suggestions for typeahead.
     */
    public function suggest(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json(['data' => []]);
        }

        $products = Product::query()
            ->with([
                'images' => function ($query) {
                    $query->ordered()->limit(1);
                },
                'brand:id,name',
            ])
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                      ->orWhere('sku', 'like', "%{$term}%");
            })
            ->orderByDesc('sales_count')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'sku', 'main_image', 'price', 'sale_price', 'brand_id']);

        $items = $products->map(function (Product $product) {
            $rawImage = $product->main_image
                ?? optional($product->images->first())->image_path
                ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=200&auto=format&fit=crop';

            $imageUrl = Str::startsWith($rawImage, ['http://', 'https://', '//'])
                ? $rawImage
                : asset($rawImage);

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'brand' => $product->brand?->name,
                'price' => (float) $product->current_price,
                'image' => $imageUrl,
            ];
        });

        return response()->json(['data' => $items]);
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        return view('product.checkout');
    }

    /**
     * Calculate discount percentage between original and sale prices.
     */
    private function calculateDiscountPercentage($originalPrice, $salePrice): int
    {
        if (! $salePrice || $salePrice >= $originalPrice || $originalPrice <= 0) {
            return 0;
        }

        return (int) round((($originalPrice - $salePrice) / $originalPrice) * 100);
    }

    /**
     * Retrieve a rounded rating for a product if available.
     */
    private function getProductRating(Product $product): ?float
    {
        if ($product->relationLoaded('reviews')) {
            $average = $product->reviews->avg('rating');
        } else {
            $average = $product->reviews()->avg('rating');
        }

        return $average ? round((float) $average, 1) : null;
    }

    /**
     * Resolve a primary image URL suitable for display.
     */
    private function getProductImage(Product $product): string
    {
        $imagePath = $product->main_image;

        if (! $imagePath && $product->relationLoaded('images')) {
            $imagePath = optional($product->images->sortBy('sort_order')->first())->image_path;
        } elseif (! $imagePath) {
            $imagePath = optional($product->images()->orderBy('sort_order')->first())->image_path;
        }

        if ($imagePath && Str::startsWith($imagePath, ['http://', 'https://', '//'])) {
            return $imagePath;
        }

        if ($imagePath) {
            return asset($imagePath);
        }

        return 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop';
    }
}
