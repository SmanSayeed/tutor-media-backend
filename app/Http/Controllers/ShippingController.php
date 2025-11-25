<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShippingService;
use Illuminate\Http\JsonResponse;

/**
 * ShippingController
 *
 * Handles shipping-related API endpoints.
 */
class ShippingController extends Controller
{
    protected ShippingService $shippingService;

    /**
     * Create a new controller instance.
     *
     * @param ShippingService $shippingService
     */
    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Get districts for a given division.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDistricts(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'division_name' => 'required|string|max:255',
        ]);

        try {
            // Get districts using the service
            $districts = $this->shippingService->getDistricts(
                $validated['division_name']
            );

            // Return the districts as JSON
            return response()->json([
                'success' => true,
                'districts' => $districts,
            ]);

        } catch (\InvalidArgumentException $e) {
            // Handle validation errors from the service
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);

        } catch (\Exception $e) {
            // Handle any other errors
            \Log::error('Error in ShippingController@getDistricts: ' . $e->getMessage(), [
                'division_name' => $validated['division_name'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Unable to retrieve districts. Please try again later.',
            ], 500);
        }
    }

    /**
     * Get the default shipping charge.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDefaultCharge(Request $request): JsonResponse
    {
        try {
            // Get the default shipping charge from the service
            $defaultCharge = $this->shippingService->getDefaultShippingCharge();

            // Return the default shipping charge as JSON
            return response()->json([
                'success' => true,
                'default_shipping_charge' => $defaultCharge,
            ]);

        } catch (\Exception $e) {
            // Handle any errors
            \Log::error('Error in ShippingController@getDefaultCharge: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Unable to retrieve default shipping charge. Please try again later.',
            ], 500);
        }
    }

    /**
     * Calculate shipping charge based on division and zone.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function calculateCharge(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'division_name' => 'required|string|max:255',
            'zone_name' => 'required|string|max:255',
        ]);

        try {
            // Calculate the shipping charge using the service
            $charge = $this->shippingService->calculateShippingCharge(
                $validated['division_name'],
                $validated['zone_name']
            );

            // Return the shipping charge as JSON
            return response()->json([
                'success' => true,
                'shipping_charge' => $charge,
            ]);

        } catch (\InvalidArgumentException $e) {
            // Handle validation errors from the service
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);

        } catch (\Exception $e) {
            // Handle any other errors
            \Log::error('Error in ShippingController@calculateCharge: ' . $e->getMessage(), [
                'division_name' => $validated['division_name'] ?? null,
                'zone_name' => $validated['zone_name'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Unable to calculate shipping charge. Please try again later.',
            ], 500);
        }
    }
}
