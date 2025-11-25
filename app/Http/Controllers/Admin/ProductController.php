<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'childCategory', 'brand', 'variants']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Stock filter
        if ($request->filled('stock')) {
            if ($request->stock === 'in_stock') {
                $query->where(function($q) {
                    $q->where('track_inventory', false)
                      ->orWhereHas('variants', function($variantQuery) {
                          $variantQuery->where('stock_quantity', '>', 0);
                      });
                });
            } elseif ($request->stock === 'out_of_stock') {
                $query->where('track_inventory', true)
                      ->whereDoesntHave('variants', function($variantQuery) {
                          $variantQuery->where('stock_quantity', '>', 0);
                      });
            } elseif ($request->stock === 'low_stock') {
                $query->where('track_inventory', true)
                      ->whereHas('variants', function($variantQuery) {
                          $variantQuery->where('stock_quantity', '>', 0)
                                       ->whereRaw('stock_quantity <= (SELECT min_stock_level FROM products WHERE products.id = product_variants.product_id)');
                      });
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortBy === 'name') {
            $query->orderBy('name', $sortDirection);
        } elseif ($sortBy === 'price') {
            $query->orderBy('price', $sortDirection);
        } elseif ($sortBy === 'stock') {
            // Sort by total stock from variants
            $query->withCount(['variants as total_stock' => function($q) {
                $q->selectRaw('sum(stock_quantity)');
            }])->orderBy('total_stock', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $products = $query->paginate(15)->withQueryString();

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.products', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();
        return view('admin.create-product', compact('categories', 'brands', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:255|unique:products',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'color_id' => 'nullable|exists:colors,id',
            'additional_images' => 'nullable|array|max:10',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'specifications' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'variants' => 'required|array|min:1',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.stock_quantity' => 'required|integer|min:0',
        ];



        $validated = $request->validate($rules);

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $imageName = time() . '_main.' . $request->main_image->extension();
            $request->main_image->move(public_path('images/products'), $imageName);
            $validated['main_image'] = 'images/products/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['is_featured'] = $request->has('is_featured') ? $request->boolean('is_featured') : false;
        $validated['features'] = $request->features ?? [];
        $validated['specifications'] = $request->specifications ?? [];

        // Convert meta_keywords from comma-separated string to array
        if (!empty($validated['meta_keywords'])) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $validated['meta_keywords']));
        } else {
            $validated['meta_keywords'] = [];
        }

        $product = Product::create($validated);
        $product->load('color');

        // Create variants
        foreach ($request->variants as $variantData) {
            $variantAttributes = [
                'size_id' => $variantData['size_id'],
                'stock_quantity' => $variantData['stock_quantity'],
                'price' => $product->price, // Use the product price
                'sku' => $product->sku ? $product->sku . '-' . $variantData['size_id'] : null,
                'is_active' => true,
            ];

            $product->variants()->create($variantAttributes);
        }

        // Set the product price to the first variant's price if not set
        if (!$product->price && count($product->variants) > 0) {
            $product->price = $product->variants->first()->price;
            $product->save();
        }

        // Color is already set in the product creation/update

        // Handle additional images upload
        if ($request->hasFile('additional_images')) {
            $this->uploadAdditionalImages($request, $product);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'subcategory', 'childCategory', 'brand', 'images', 'variants.size']);
        return view('admin.product-details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)->active()->ordered()->get();
        $childCategories = ChildCategory::where('subcategory_id', $product->subcategory_id)->active()->ordered()->get();

        $product->load(['variants.size', 'color', 'images']);

        return view('admin.edit-product', compact('product', 'categories', 'brands', 'colors', 'sizes', 'subcategories', 'childCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'color_id' => 'nullable|exists:colors,id',
            'additional_images' => 'nullable|array|max:10',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'specifications' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'variants' => 'nullable|array',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.stock_quantity' => 'required|integer|min:0',
        ]);

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            // Delete old main image if exists
            if ($product->main_image && file_exists(public_path($product->main_image))) {
                unlink(public_path($product->main_image));
            }

            $imageName = time() . '_main.' . $request->main_image->extension();
            $request->main_image->move(public_path('images/products'), $imageName);
            $validated['main_image'] = 'images/products/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $product->is_active;
        $validated['is_featured'] = $request->has('is_featured') ? $request->boolean('is_featured') : $product->is_featured;
        $validated['features'] = $request->features ?? $product->features ?? [];
        $validated['specifications'] = $request->specifications ?? $product->specifications ?? [];

        // Convert meta_keywords from comma-separated string to array
        if (!empty($validated['meta_keywords'])) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $validated['meta_keywords']));
        } else {
            $validated['meta_keywords'] = $product->meta_keywords ?? [];
        }

        $product->update($validated);

        // Handle variants
        if ($request->has('variants') && is_array($request->variants)) {
            // Delete existing variants
            $product->variants()->delete();

            // Create new variants
            foreach ($request->variants as $variantData) {
                if (empty($variantData['size_id']) || !isset($variantData['stock_quantity'])) {
                    continue;
                }

                $size = Size::find($variantData['size_id']);
                if (!$size) continue;

                $variantAttributes = [
                    'size_id' => $variantData['size_id'],
                    'stock_quantity' => $variantData['stock_quantity'],
                    'is_active' => true,                 
                ];

                $product->variants()->create($variantAttributes);
            }
        }

        // Color is already updated in the product update

        // Handle additional images upload
        if ($request->hasFile('additional_images')) {
            $this->uploadAdditionalImages($request, $product);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product has variants
        if ($product->variants()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete product "' . $product->name . '" as it has variants.');
        }

        // Delete main image if exists
        if ($product->main_image && file_exists(public_path($product->main_image))) {
            unlink(public_path($product->main_image));
        }

        // Delete all product images
        foreach ($product->images as $image) {
            if ($image->image_path && file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->ids)->get();

        // Check if any products have variants
        $productsWithVariants = [];
        foreach ($products as $product) {
            if ($product->variants()->exists()) {
                $productsWithVariants[] = $product->name;
            }
        }

        if (!empty($productsWithVariants)) {
            return redirect()->back()->with('error', 'Cannot delete the following products as they have variants: ' . implode(', ', $productsWithVariants));
        }

        foreach ($products as $product) {
            // Delete main image if exists
            if ($product->main_image && file_exists(public_path($product->main_image))) {
                unlink(public_path($product->main_image));
            }

            // Delete all product images
            foreach ($product->images as $image) {
                if ($image->image_path && file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
            }
        }

        Product::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected products deleted successfully!']);
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $product->is_active
        ]);
    }

    /**
     * Get subcategories by category ID for AJAX requests.
     */
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)
            ->active()
            ->ordered()
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }

    /**
     * Get child categories by subcategory ID for AJAX requests.
     */
    public function getChildCategories(Request $request)
    {
        $childCategories = ChildCategory::where('subcategory_id', $request->subcategory_id)
            ->active()
            ->ordered()
            ->get(['id', 'name']);

        return response()->json($childCategories);
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'variant_id' => 'required|exists:product_variants,id',
                'stock_quantity' => 'required|integer|min:0',
            ]);

            // Verify the variant belongs to this product
            $variant = $product->variants()->find($validated['variant_id']);
            
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variant not found or does not belong to this product.'
                ], 404);
            }

            $oldStock = $variant->stock_quantity;
            $variant->update(['stock_quantity' => $validated['stock_quantity']]);

            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully from ' . $oldStock . ' to ' . $validated['stock_quantity'],
                'stock_quantity' => $variant->stock_quantity,
                'variant_name' => $variant->name,
                'old_stock' => $oldStock
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all()),
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating stock: ' . $e->getMessage()
        ], 500);
        }
    }

    /**
     * Upload additional product images.
     */
    private function uploadAdditionalImages(Request $request, Product $product)
    {
        $images = [];
        foreach ($request->file('additional_images') as $index => $file) {
            $imageName = time() . '_' . $index . '.' . $file->extension();
            $file->move(public_path('images/products'), $imageName);

            $image = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'images/products/' . $imageName,
                'alt_text' => $product->name . ' - Image ' . ($index + 1),
                'is_primary' => false,
                'sort_order' => $index,
            ]);

            $images[] = $image;
        }

        return $images;
    }

    /**
     * Manage product stock.
     */
    public function manageStock(Product $product)
    {
        $product->load(['variants.size']);
        return view('admin.manage-stock', compact('product'));
    }

    /**
     * Manage product images (gallery).
     */
    public function manageImages(Product $product)
    {
        $product->load('images');
        return view('admin.product-images', compact('product'));
    }

    /**
     * Upload product images.
     */
    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        foreach ($request->file('images') as $index => $file) {
            $imageName = time() . '_' . $index . '.' . $file->extension();
            $file->move(public_path('images/products'), $imageName);

            $image = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'images/products/' . $imageName,
                'alt_text' => $product->name . ' - Image ' . ($index + 1),
                'is_primary' => $request->has('set_primary') && $index === 0,
                'sort_order' => $index,
            ]);

            $images[] = $image;
        }

        // If this is the first image and no primary image exists, make it primary
        if (empty($product->images()->primary()->first()) && !empty($images)) {
            $images[0]->update(['is_primary' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully!',
            'images' => $images
        ]);
    }

    /**
     * Set primary image.
     */
    public function setPrimaryImage(ProductImage $image)
    {
        // Remove primary flag from all images of this product
        $image->product->images()->update(['is_primary' => false]);

        // Set this image as primary
        $image->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Primary image updated successfully!'
        ]);
    }

    /**
     * Delete product image.
     */
    public function deleteImage(ProductImage $image)
    {
        // Delete file if exists
        if ($image->image_path && file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully!'
        ]);
    }

    /**
     * Manage product variants.
     */
    public function manageVariants(Product $product)
    {
        $product->load(['variants.size']);
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();
        return view('admin.product-variants', compact('product', 'colors', 'sizes'));
    }

    /**
     * Store product variant.
     */
    public function storeVariant(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255|unique:product_variants,sku',
                'color_id' => 'nullable|exists:colors,id',
                'size_id' => 'nullable|exists:sizes,id',
                'price' => 'nullable|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0|lt:price',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'nullable|boolean',
            ], [
                'name.required' => 'Variant name is required',
                'sku.required' => 'SKU is required',
                'sku.unique' => 'This SKU already exists. Please use a unique SKU',
                'sale_price.lt' => 'Sale price must be less than regular price',
                'image.image' => 'The file must be an image',
                'image.max' => 'Image size cannot exceed 2MB',
                'is_active.boolean' => 'The is active field must be true or false.',
            ]);

            // Ensure variants directory exists
            $variantPath = public_path('images/products/variants');
            if (!file_exists($variantPath)) {
                mkdir($variantPath, 0755, true);
            }

            // Handle variant image upload
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move($variantPath, $imageName);
                $validated['image'] = 'images/products/variants/' . $imageName;
            }

            // Set default values
            $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;

            // Build attributes array
            $attributes = [];
            if (!empty($validated['color_id'])) {
                $color = Color::find($validated['color_id']);
                $attributes['color'] = $color ? $color->name : null;
            }
            if (!empty($validated['size_id'])) {
                $size = Size::find($validated['size_id']);
                $attributes['size'] = $size ? $size->name : null;
            }
            $validated['attributes'] = $attributes;

            // Create variant
            $variant = $product->variants()->create($validated);

            // Log success for debugging
            \Log::info('Variant created successfully', [
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'sku' => $variant->sku,
                'user_id' => auth()->id()
            ]);

            // Check if this is an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Variant created successfully!',
                    'variant' => $variant
                ], 201);
            }          

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Variant validation failed', [
                'product_id' => $product->id,
                'errors' => $e->errors(),
                'user_id' => auth()->id()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }

        } catch (\Exception $e) {
            \Log::error('Error creating variant: ' . $e->getMessage(), [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the variant: ' . $e->getMessage()
                ], 500);
            }

            // Traditional form submission - redirect back with error
            return redirect()->back()
                ->with('error', 'An error occurred while creating the variant: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing product variant.
     */
    public function editVariant(ProductVariant $variant)
    {
        $variant->load(['color', 'size', 'product']);
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.edit-product-variant', compact('variant', 'colors', 'sizes'));
    }

    /**
     * Update product variant.
     */
    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['required', 'string', 'max:255', Rule::unique('product_variants')->ignore($variant->id)],
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle variant image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($variant->image && file_exists(public_path($variant->image))) {
                unlink(public_path($variant->image));
            }

            $imageName = time() . '_variant.' . $request->image->extension();
            $request->image->move(public_path('images/products/variants'), $imageName);
            $validated['image'] = 'images/products/variants/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $variant->is_active;
        $validated['attributes'] = [
            'color' => $validated['color_id'] ? Color::find($validated['color_id'])->name : null,
            'size' => $validated['size_id'] ? Size::find($validated['size_id'])->name : null,
        ];

        $variant->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Variant updated successfully!'
        ]);
    }

    /**
     * Delete product variant.
     */
    public function deleteVariant(ProductVariant $variant)
    {
        // Delete image if exists
        if ($variant->image && file_exists(public_path($variant->image))) {
            unlink(public_path($variant->image));
        }

        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variant deleted successfully!'
        ]);
    }
}
