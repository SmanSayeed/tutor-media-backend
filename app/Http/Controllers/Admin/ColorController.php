<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Color::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('hex_code', 'like', "%{$search}%");
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
        } elseif ($sortBy === 'code') {
            $query->orderBy('code', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $colors = $query->paginate(15)->withQueryString();

        return view('admin.colors', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create-color');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:colors,code',
            'hex_code' => 'nullable|string|max:7|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        Color::create($validated);

        return redirect()->route('admin.colors.index')->with('success', 'Color created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return view('admin.color-details', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.edit-color', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:255', Rule::unique('colors')->ignore($color->id)],
            'hex_code' => 'nullable|string|max:7|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $color->is_active;

        $color->update($validated);

        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        // Check if color is used in any products
        if ($color->products()->exists()) {
            return redirect()->route('admin.colors.index')->with('error', 'Cannot delete color as it is being used by products.');
        }

        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully!');
    }

    /**
     * Toggle color status.
     */
    public function toggleStatus(Color $color)
    {
        $color->update(['is_active' => !$color->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $color->is_active
        ]);
    }

    /**
     * Bulk delete colors.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:colors,id'
        ]);

        $colors = Color::whereIn('id', $request->ids)->get();

        // Check if any colors are being used
        $usedColors = [];
        foreach ($colors as $color) {
            if ($color->products()->exists()) {
                $usedColors[] = $color->name;
            }
        }

        if (!empty($usedColors)) {
            return redirect()->back()->with('error', 'Cannot delete the following colors as they are being used by product variants: ' . implode(', ', $usedColors));
        }

        Color::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Selected colors deleted successfully!');
    }
}