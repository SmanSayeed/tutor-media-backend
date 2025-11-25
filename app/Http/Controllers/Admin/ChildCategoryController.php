<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ChildCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ChildCategory::with(['subcategory.category']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Subcategory filter
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->whereHas('subcategory', function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
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
        } elseif ($sortBy === 'subcategory') {
            $query->join('subcategories', 'child_categories.subcategory_id', '=', 'subcategories.id')
                  ->orderBy('subcategories.name', $sortDirection)
                  ->select('child_categories.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $childCategories = $query->paginate(15)->withQueryString();

        $subcategories = Subcategory::with('category')->active()->ordered()->get();
        $categories = Category::active()->ordered()->get();

        return view('admin.child-categories', compact('childCategories', 'subcategories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::with('category')->active()->ordered()->get();
        $categories = Category::active()->ordered()->get();
        return view('admin.create-child-category', compact('subcategories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:child_categories',
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
            $request->image->move(public_path('images/childcategories'), $imageName);
            $validated['image'] = 'images/childcategories/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        ChildCategory::create($validated);

        return redirect()->route('admin.child-categories.index')->with('success', 'Child category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildCategory $childCategory)
    {
        $childCategory->load(['subcategory.category', 'products']);
        return view('admin.child-category-details', compact('childCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildCategory $childCategory)
    {
        $subcategories = Subcategory::with('category')->active()->ordered()->get();
        $categories = Category::active()->ordered()->get();
        return view('admin.edit-child-category', compact('childCategory', 'subcategories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildCategory $childCategory)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('child_categories')->ignore($childCategory->id)],
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
            if ($childCategory->image && file_exists(public_path($childCategory->image))) {
                unlink(public_path($childCategory->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/childcategories'), $imageName);
            $validated['image'] = 'images/childcategories/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        $childCategory->update($validated);

        return redirect()->route('admin.child-categories.index')->with('success', 'Child category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildCategory $childCategory)
    {
        // Delete image if exists
        if ($childCategory->image && file_exists(public_path($childCategory->image))) {
            unlink(public_path($childCategory->image));
        }

        $childCategory->delete();

        return redirect()->route('admin.child-categories.index')->with('success', 'Child category deleted successfully!');
    }

    /**
     * Bulk delete child categories.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:child_categories,id'
        ]);

        $childCategories = ChildCategory::whereIn('id', $request->ids)->get();

        foreach ($childCategories as $childCategory) {
            // Delete image if exists
            if ($childCategory->image && file_exists(public_path($childCategory->image))) {
                unlink(public_path($childCategory->image));
            }
        }

        ChildCategory::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected child categories deleted successfully!']);
    }

    /**
     * Toggle child category status.
     */
    public function toggleStatus(ChildCategory $childCategory)
    {
        $childCategory->update(['is_active' => !$childCategory->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $childCategory->is_active
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
}
