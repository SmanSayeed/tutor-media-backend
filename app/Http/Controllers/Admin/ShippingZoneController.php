<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZoneArea;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShippingZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ZoneArea::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('division_name', 'like', "%{$search}%")
                  ->orWhere('zone_name', 'like', "%{$search}%");
            });
        }

        // Division filter
        if ($request->filled('division')) {
            $query->where('division_name', $request->division);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortBy === 'division_name') {
            $query->orderBy('division_name', $sortDirection);
        } elseif ($sortBy === 'zone_name') {
            $query->orderBy('zone_name', $sortDirection);
        } elseif ($sortBy === 'shipping_charge') {
            $query->orderBy('shipping_charge', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $zones = $query->paginate(15)->withQueryString();

        // Get unique divisions for filter dropdown
        $divisions = ZoneArea::distinct()->pluck('division_name')->sort();

        return view('admin.shipping-zones', compact('zones', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create-shipping-zone');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'division_name' => 'required|string|max:255',
            'zone_name' => 'required|string|max:255',
            'shipping_charge' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,deactive',
        ]);

        // Check for unique combination
        $exists = ZoneArea::where('division_name', $validated['division_name'])
                          ->where('zone_name', $validated['zone_name'])
                          ->exists();

        if ($exists) {
            return back()->withErrors(['zone_name' => 'A zone with this division and zone name already exists.'])
                        ->withInput();
        }

        ZoneArea::create($validated);

        return redirect()->route('admin.shipping-zones.index')
                        ->with('success', 'Shipping zone created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ZoneArea $zone)
    {
        return view('admin.shipping-zone-details', compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZoneArea $zone)
    {
        return view('admin.edit-shipping-zone', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ZoneArea $zone)
    {
        $validated = $request->validate([
            'division_name' => 'required|string|max:255',
            'zone_name' => 'required|string|max:255',
            'shipping_charge' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,deactive',
        ]);

        // Check for unique combination (excluding current record)
        $exists = ZoneArea::where('division_name', $validated['division_name'])
                          ->where('zone_name', $validated['zone_name'])
                          ->where('id', '!=', $zone->id)
                          ->exists();

        if ($exists) {
            return back()->withErrors(['zone_name' => 'A zone with this division and zone name already exists.'])
                        ->withInput();
        }

        $zone->update($validated);

        return redirect()->route('admin.shipping-zones.index')
                        ->with('success', 'Shipping zone updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZoneArea $zone)
    {
        $zone->delete();

        return redirect()->route('admin.shipping-zones.index')
                        ->with('success', 'Shipping zone deleted successfully!');
    }

    /**
     * Bulk delete shipping zones.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:zone_areas,id'
        ]);

        ZoneArea::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected shipping zones deleted successfully!']);
    }

    /**
     * Toggle shipping zone status.
     */
    public function toggleStatus(ZoneArea $zone)
    {
        $zone->update(['status' => $zone->status === 'active' ? 'deactive' : 'active']);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'status' => $zone->status
        ]);
    }

    /**
     * Update shipping charge for a zone.
     */
    public function updateCharge(Request $request, ZoneArea $zone)
    {
        $validated = $request->validate([
            'shipping_charge' => 'nullable|numeric|min:0',
        ]);

        $zone->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Shipping charge updated successfully!',
            'shipping_charge' => $zone->shipping_charge
        ]);
    }
}
