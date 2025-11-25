<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShippingSettingsController extends Controller
{
    /**
     * Display the shipping settings page.
     */
    public function index()
    {
        $defaultShippingCharge = Setting::get('default_shipping_charge', config('shipping.default_shipping_charge', 60));

        return view('admin.shipping-settings', compact('defaultShippingCharge'));
    }

    /**
     * Update the default shipping charge.
     */
    public function update(Request $request)
    {
        $request->validate([
            'default_shipping_charge' => 'required|numeric|min:0',
        ]);

        try {
            Setting::set('default_shipping_charge', $request->default_shipping_charge, 'integer');

            return redirect()->route('admin.shipping-settings.index')
                           ->with('success', 'Default shipping charge updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update shipping charge. Please try again.'])
                           ->withInput();
        }
    }
}
