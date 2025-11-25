<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\ZoneArea;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * ShippingService
 *
 * Handles shipping-related calculations and operations.
 */
class ShippingService
{
    /**
     * Get districts (zones) for a given division.
     *
     * This method queries the ZoneArea model for distinct zone names
     * within the specified division that are active.
     *
     * @param string $division_name The name of the division.
     * @return array List of district names.
     * @throws \InvalidArgumentException If division_name is empty.
     */
    public function getDistricts(string $division_name): array
    {
        // Validate input parameter
        if (empty($division_name)) {
            throw new \InvalidArgumentException('Division name is required.');
        }

        try {
            // Query distinct zone names for the division
            $districts = ZoneArea::where('division_name', $division_name)
                ->where('status', 'active')
                ->distinct()
                ->pluck('zone_name')
                ->toArray();

            return $districts;

        } catch (\Exception $e) {
            // Log the error and return empty array
            \Log::error('Error getting districts: ' . $e->getMessage(), [
                'division_name' => $division_name,
            ]);

            return [];
        }
    }

    /**
     * Get the default shipping charge.
     *
     * This method returns the default shipping charge from the database settings,
     * falling back to the config value if not set.
     *
     * @return float The default shipping charge amount.
     */
    public function getDefaultShippingCharge(): float
    {
        try {
            // Get default shipping charge from database, return 0 if not set
            return (float) Setting::get('default_shipping_charge', 0);
        } catch (\Exception $e) {
            // Log the error and return 0
            \Log::error('Error getting default shipping charge: ' . $e->getMessage());

            return 0;
        }
    }

    /**
     * Calculate shipping charge for a given division and zone.
     *
     * This method queries the ZoneArea model for the specific zone and returns
     * the shipping_charge if set. If the shipping_charge is null or the zone
     * is not found, it falls back to the default shipping charge from config.
     *
     * @param string $division_name The name of the division.
     * @param string $zone_name The name of the zone (district).
     * @return float The shipping charge amount.
     * @throws \InvalidArgumentException If division_name or zone_name is empty.
     */
    public function calculateShippingCharge(string $division_name, string $zone_name): float
    {
        // Validate input parameters
        if (empty($division_name) || empty($zone_name)) {
            throw new \InvalidArgumentException('Division name and zone name are required.');
        }

        try {
            // Query the ZoneArea model for the specific division and zone
            $zoneArea = ZoneArea::where('division_name', $division_name)
                ->where('zone_name', $zone_name)
                ->where('status', 'active')
                ->first();

            // If zone area exists and has a shipping charge set, return it
            if ($zoneArea && !is_null($zoneArea->shipping_charge)) {
                return (float) $zoneArea->shipping_charge;
            }

            // Fall back to default shipping charge from database, or 0 if not set
            return (float) Setting::get('default_shipping_charge', 0);

        } catch (ModelNotFoundException $e) {
            // If no zone area is found, return default or 0
            return (float) Setting::get('default_shipping_charge', 0);
        } catch (\Exception $e) {
            // Log the error and return 0
            \Log::error('Error calculating shipping charge: ' . $e->getMessage(), [
                'division_name' => $division_name,
                'zone_name' => $zone_name,
            ]);

            return 0;
        }
    }
}
