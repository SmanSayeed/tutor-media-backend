<?php

namespace Tests\Unit\Services;

use App\Models\ZoneArea;
use App\Services\ShippingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingServiceTest extends TestCase
{
    use RefreshDatabase;

    private ShippingService $shippingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shippingService = new ShippingService();
    }

    /**
     * Test calculateShippingCharge with valid division and zone that has shipping_charge set.
     */
    public function test_calculate_shipping_charge_with_valid_zone_and_charge()
    {
        // Create a zone area with a specific shipping charge
        ZoneArea::create([
            'division_name' => 'Dhaka',
            'zone_name' => 'Dhaka',
            'shipping_charge' => 50.00,
            'status' => 'active',
        ]);

        $charge = $this->shippingService->calculateShippingCharge('Dhaka', 'Dhaka');

        $this->assertEquals(50.00, $charge);
    }

    /**
     * Test calculateShippingCharge with valid division and zone but null shipping_charge (fallback to default).
     */
    public function test_calculate_shipping_charge_with_null_charge_fallback_to_default()
    {
        // Create a zone area with null shipping charge
        ZoneArea::create([
            'division_name' => 'Dhaka',
            'zone_name' => 'Dhaka',
            'shipping_charge' => null,
            'status' => 'active',
        ]);

        $charge = $this->shippingService->calculateShippingCharge('Dhaka', 'Dhaka');

        $this->assertEquals(60.00, $charge); // Default from config
    }

    /**
     * Test calculateShippingCharge with invalid division/zone (not found, fallback to default).
     */
    public function test_calculate_shipping_charge_with_invalid_zone_fallback_to_default()
    {
        $charge = $this->shippingService->calculateShippingCharge('InvalidDivision', 'InvalidZone');

        $this->assertEquals(60.00, $charge); // Default from config
    }

    /**
     * Test calculateShippingCharge throws exception for empty division or zone.
     */
    public function test_calculate_shipping_charge_throws_exception_for_empty_inputs()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Division name and zone name are required.');

        $this->shippingService->calculateShippingCharge('', 'Dhaka');
    }

    /**
     * Test calculateShippingCharge throws exception for empty zone.
     */
    public function test_calculate_shipping_charge_throws_exception_for_empty_zone()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Division name and zone name are required.');

        $this->shippingService->calculateShippingCharge('Dhaka', '');
    }

    /**
     * Test calculateShippingCharge with inactive zone (fallback to default).
     */
    public function test_calculate_shipping_charge_with_inactive_zone_fallback_to_default()
    {
        // Create an inactive zone area
        ZoneArea::create([
            'division_name' => 'Dhaka',
            'zone_name' => 'Dhaka',
            'shipping_charge' => 50.00,
            'status' => 'deactive',
        ]);

        $charge = $this->shippingService->calculateShippingCharge('Dhaka', 'Dhaka');

        $this->assertEquals(60.00, $charge); // Default from config
    }

    /**
     * Test calculateShippingCharge with special characters in division and zone names.
     */
    public function test_calculate_shipping_charge_with_special_characters()
    {
        // Create a zone area with special characters
        ZoneArea::create([
            'division_name' => 'Dhaka-Division',
            'zone_name' => 'Dhaka-Zone',
            'shipping_charge' => 75.50,
            'status' => 'active',
        ]);

        $charge = $this->shippingService->calculateShippingCharge('Dhaka-Division', 'Dhaka-Zone');

        $this->assertEquals(75.50, $charge);
    }

    /**
     * Test calculateShippingCharge with case insensitive matching (assuming database is case sensitive).
     */
    public function test_calculate_shipping_charge_case_sensitive()
    {
        // Create a zone area with specific case
        ZoneArea::create([
            'division_name' => 'Dhaka',
            'zone_name' => 'Dhaka',
            'shipping_charge' => 50.00,
            'status' => 'active',
        ]);

        // Query with different case should not match (assuming case sensitive)
        $charge = $this->shippingService->calculateShippingCharge('dhaka', 'dhaka');

        $this->assertEquals(60.00, $charge); // Default from config
    }
}
