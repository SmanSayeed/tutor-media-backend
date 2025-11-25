<?php

namespace App\Http\Controllers;

use App\Models\AdvancePaymentSetting;
use Illuminate\Http\Request;

class AdvancePaymentController extends Controller
{
    public function index()
    {
        $settings = AdvancePaymentSetting::current();
        return view('admin.advance_payment_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'advance_payment_status' => 'required|boolean',
            'advance_payment_amount' => 'nullable|required_if:advance_payment_status,true|numeric|gt:0',
        ]);

        $settings = AdvancePaymentSetting::first();
        if (!$settings) {
            $settings = new AdvancePaymentSetting();
        }

        $settings->advance_payment_status = $request->advance_payment_status;
        $settings->advance_payment_amount = $request->advance_payment_status ? $request->advance_payment_amount : null;
        $settings->save();

        return response()->json(['success' => true, 'message' => 'Settings updated successfully.']);
    }
}
