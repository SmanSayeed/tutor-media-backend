<?php

namespace Database\Seeders;

use App\Models\ZoneArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * ZoneAreaSeeder
 *
 * Seeds the zone_areas table with all 64 districts of Bangladesh
 * organized under their respective divisions.
 */
class ZoneAreaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * Inserts all districts with their divisions, setting shipping_charge to null
     * and status to 'active' for all entries.
     */
    public function run(): void
    {
        $zoneAreas = [
            // Dhaka Division (13 districts)
            ['division_name' => 'Dhaka', 'zone_name' => 'Dhaka'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Gazipur'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Kishoreganj'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Manikganj'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Munshiganj'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Narayanganj'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Narsingdi'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Tangail'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Faridpur'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Gopalganj'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Madaripur'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Rajbari'],
            ['division_name' => 'Dhaka', 'zone_name' => 'Shariatpur'],

            // Chittagong Division (11 districts)
            ['division_name' => 'Chittagong', 'zone_name' => 'Chittagong'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Cox\'s Bazar'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Bandarban'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Rangamati'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Khagrachhari'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Feni'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Lakshmipur'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Comilla'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Chandpur'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Brahmanbaria'],
            ['division_name' => 'Chittagong', 'zone_name' => 'Noakhali'],

            // Rajshahi Division (8 districts)
            ['division_name' => 'Rajshahi', 'zone_name' => 'Rajshahi'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Chapainawabganj'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Naogaon'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Natore'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Joypurhat'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Pabna'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Bogra'],
            ['division_name' => 'Rajshahi', 'zone_name' => 'Sirajganj'],

            // Khulna Division (10 districts)
            ['division_name' => 'Khulna', 'zone_name' => 'Khulna'],
            ['division_name' => 'Khulna', 'zone_name' => 'Bagerhat'],
            ['division_name' => 'Khulna', 'zone_name' => 'Chuadanga'],
            ['division_name' => 'Khulna', 'zone_name' => 'Jessore'],
            ['division_name' => 'Khulna', 'zone_name' => 'Jhenaidah'],
            ['division_name' => 'Khulna', 'zone_name' => 'Kustia'],
            ['division_name' => 'Khulna', 'zone_name' => 'Magura'],
            ['division_name' => 'Khulna', 'zone_name' => 'Meherpur'],
            ['division_name' => 'Khulna', 'zone_name' => 'Narail'],
            ['division_name' => 'Khulna', 'zone_name' => 'Satkhira'],

            // Barisal Division (6 districts)
            ['division_name' => 'Barisal', 'zone_name' => 'Barisal'],
            ['division_name' => 'Barisal', 'zone_name' => 'Bhola'],
            ['division_name' => 'Barisal', 'zone_name' => 'Jhalokati'],
            ['division_name' => 'Barisal', 'zone_name' => 'Patuakhali'],
            ['division_name' => 'Barisal', 'zone_name' => 'Pirojpur'],
            ['division_name' => 'Barisal', 'zone_name' => 'Barguna'],

            // Sylhet Division (4 districts)
            ['division_name' => 'Sylhet', 'zone_name' => 'Sylhet'],
            ['division_name' => 'Sylhet', 'zone_name' => 'Habiganj'],
            ['division_name' => 'Sylhet', 'zone_name' => 'Maulvibazar'],
            ['division_name' => 'Sylhet', 'zone_name' => 'Sunamganj'],

            // Rangpur Division (8 districts)
            ['division_name' => 'Rangpur', 'zone_name' => 'Rangpur'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Dinajpur'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Gaibandha'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Kurigram'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Lalmonirhat'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Nilphamari'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Panchagarh'],
            ['division_name' => 'Rangpur', 'zone_name' => 'Thakurgaon'],

            // Mymensingh Division (4 districts)
            ['division_name' => 'Mymensingh', 'zone_name' => 'Mymensingh'],
            ['division_name' => 'Mymensingh', 'zone_name' => 'Jamalpur'],
            ['division_name' => 'Mymensingh', 'zone_name' => 'Netrokona'],
            ['division_name' => 'Mymensingh', 'zone_name' => 'Sherpur'],
        ];

        foreach ($zoneAreas as $zoneArea) {
            ZoneArea::updateOrCreate(
                [
                    'division_name' => $zoneArea['division_name'],
                    'zone_name' => $zoneArea['zone_name'],
                ],
                [
                    'shipping_charge' => null,
                    'status' => 'active',
                ]
            );
        }
    }
}
