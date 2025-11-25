<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortBy === 'name') {
            $query->orderBy('name', $sortDirection);
        } elseif ($sortBy === 'category') {
            $query->join('categories', 'subcategories.category_id', '=', 'categories.id')
                  ->orderBy('categories.name', $sortDirection)
                  ->select('subcategories.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $subcategories = $query->paginate(15)->withQueryString();

        $categories = Category::active()->ordered()->get();

        return view('admin.sub-categories', compact('subcategories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.create-sub-category', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subcategories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/subcategories'), $imageName);
            $validated['image'] = 'images/subcategories/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        Subcategory::create($validated);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        $subcategory->load('category', 'products');
        return view('admin.subcategory-details', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.edit-sub-category', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('subcategories')->ignore($subcategory->id)],
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subcategory->image && file_exists(public_path($subcategory->image))) {
                unlink(public_path($subcategory->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/subcategories'), $imageName);
            $validated['image'] = 'images/subcategories/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        
        if (!$subcategory) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subcategory not found or already deleted.'
                ], 404);
            }
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'Subcategory not found or already deleted.');
        }

        // Delete image if exists
        if ($subcategory->image && file_exists(public_path($subcategory->image))) {
            unlink(public_path($subcategory->image));
        }

        $subcategory->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subcategory deleted successfully!'
            ]);
        }

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully!');
    }

    /**
     * Bulk delete subcategories.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:subcategories,id'
        ]);

        $subcategories = Subcategory::whereIn('id', $request->ids)->get();

        foreach ($subcategories as $subcategory) {
            // Delete image if exists
            if ($subcategory->image && file_exists(public_path($subcategory->image))) {
                unlink(public_path($subcategory->image));
            }
        }

        Subcategory::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected subcategories deleted successfully!']);
    }

    /**
     * Toggle subcategory status.
     */
    public function toggleStatus(Subcategory $subcategory)
    {
        $subcategory->update(['is_active' => !$subcategory->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $subcategory->is_active
        ]);
    }
}
