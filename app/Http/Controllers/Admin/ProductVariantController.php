<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductVariant::withProduct();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Product filter
        if ($request->filled('product_id')) {
            $query->byProduct($request->product_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        // Stock filter
        if ($request->filled('stock')) {
            $query->filterByStock($request->stock);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortBy === 'name') {
            $query->orderBy('name', $sortDirection);
        } elseif ($sortBy === 'price') {
            $query->orderBy('price', $sortDirection);
        } elseif ($sortBy === 'stock') {
            $query->orderBy('stock_quantity', $sortDirection);
        } elseif ($sortBy === 'product') {
            $query->join('products', 'product_variants.product_id', '=', 'products.id')
                  ->orderBy('products.name', $sortDirection)
                  ->select('product_variants.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $variants = $query->paginate(15)->withQueryString();

        $products = Product::active()->orderBy('name')->get();
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.product-variants.index', compact('variants', 'products', 'colors', 'sizes'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.product-variants.create', compact('products', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:product_variants,sku',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $variantPath = public_path('images/products/variants');
            if (!file_exists($variantPath)) {
                mkdir($variantPath, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($variantPath, $imageName);
            $validated['image'] = 'images/products/variants/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

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

        ProductVariant::create($validated);

        return redirect()->route('admin.product-variants.index')->with('success', 'Variant created successfully!');
    }

    public function show(ProductVariant $variant)
    {
        $variant->load(['product', 'color', 'size']);
        return view('admin.product-variants.show', compact('variant'));
    }

    public function edit(ProductVariant $variant)
    {
        $variant->load(['product', 'color', 'size']);
        $products = Product::active()->orderBy('name')->get();
        $colors = Color::active()->orderBy('name')->get();
        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.product-variants.edit', compact('variant', 'products', 'colors', 'sizes'));
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
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

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($variant->image && file_exists(public_path($variant->image))) {
                unlink(public_path($variant->image));
            }

            $variantPath = public_path('images/products/variants');
            if (!file_exists($variantPath)) {
                mkdir($variantPath, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($variantPath, $imageName);
            $validated['image'] = 'images/products/variants/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $variant->is_active;

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

        $variant->update($validated);

        return redirect()->route('admin.product-variants.index')->with('success', 'Variant updated successfully!');
    }

    public function destroy(ProductVariant $variant)
    {
        // Delete image if exists
        if ($variant->image && file_exists(public_path($variant->image))) {
            unlink(public_path($variant->image));
        }

        $variant->delete();

        return redirect()->route('admin.product-variants.index')->with('success', 'Variant deleted successfully!');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:product_variants,id'
        ]);

        $variants = ProductVariant::whereIn('id', $request->ids)->get();

        foreach ($variants as $variant) {
            // Delete image if exists
            if ($variant->image && file_exists(public_path($variant->image))) {
                unlink(public_path($variant->image));
            }
        }

        ProductVariant::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected variants deleted successfully!']);
    }

    public function toggleStatus(ProductVariant $variant)
    {
        $variant->update(['is_active' => !$variant->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $variant->is_active
        ]);
    }

    public function updateStock(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $oldStock = $variant->stock_quantity;
        $variant->update(['stock_quantity' => $validated['stock_quantity']]);

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully from ' . $oldStock . ' to ' . $validated['stock_quantity'],
            'stock_quantity' => $variant->stock_quantity,
            'old_stock' => $oldStock
        ]);
    }
}