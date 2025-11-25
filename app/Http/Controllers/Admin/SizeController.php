<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Size::withCount('variants');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
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
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $sizes = $query->paginate(15)->withQueryString();

        return view('admin.sizes', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create-size');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        Size::create($validated);

        return redirect()->route('admin.sizes.index')->with('success', 'Size created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        $size->load(['variants.product']);
        return view('admin.size-details', compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('admin.edit-size', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $size->is_active;

        $size->update($validated);

        return redirect()->route('admin.sizes.index')->with('success', 'Size updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        // Check if size is used in any variants
        if ($size->variants()->exists()) {
            return redirect()->route('admin.sizes.index')->with('error', 'Cannot delete size as it is being used by product variants.');
        }      
        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully!');
    }

    /**
     * Toggle size status.
     */
    public function toggleStatus(Size $size)
    {
        $size->update(['is_active' => !$size->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $size->is_active
        ]);
    }

    /**
     * Bulk delete sizes.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:sizes,id'
        ]);

        $sizes = Size::whereIn('id', $request->ids)->get();

        // Check if any sizes are being used
        $usedSizes = [];
        foreach ($sizes as $size) {
            if ($size->variants()->exists()) {
                $usedSizes[] = $size->name;
            }
        }

        if (!empty($usedSizes)) {
            return redirect()->back()->with('error', 'Cannot delete the following sizes as they are being used by product variants: ' . implode(', ', $usedSizes));
        }

        Size::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected sizes deleted successfully!');
    }
}