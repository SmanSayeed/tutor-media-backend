<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if settings already exist
        if (SiteSetting::count() > 0) {
            $this->command->info('Site settings already exist. Skipping seeder.');
            return;
        }

        SiteSetting::create([
            'website_name' => 'Tutor Media',
            'website_tagline' => 'Your Perfect Pair Awaits',
            'website_description' => 'Discover the latest trends in footwear. Quality shoes for every occasion.',
            'logo_path' => null,
            'favicon_path' => null,
            'primary_email' => 'info@tutionmediabd.com',
            'secondary_email' => 'support@tutionmediabd.com',
            'primary_phone' => '+880 1234 567890',
            'secondary_phone' => null,
            'physical_address' => '123 Main Street, Dhaka, Bangladesh',
            'business_hours' => 'Mon-Fri: 9:00 AM - 6:00 PM, Sat: 10:00 AM - 4:00 PM',
            'social_media_links' => [
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'linkedin' => null,
                'youtube' => null,
                'tiktok' => null,
            ],
            'default_currency' => 'BDT',
            'default_language' => 'en',
            'supported_languages' => ['en', 'bn'],
            'timezone' => 'Asia/Dhaka',
            'meta_title' => 'tutionmediabd - Your Perfect Pair Awaits',
            'meta_description' => 'Discover the latest trends in footwear. Quality shoes for every occasion. Shop now!',
            'meta_keywords' => 'shoes, footwear, fashion, online shopping, bangladesh',
            'og_title' => 'tutionmediabd - Your Perfect Pair Awaits',
            'og_description' => 'Discover the latest trends in footwear. Quality shoes for every occasion.',
            'og_image' => null,
            'canonical_url' => null,
            'maintenance_mode' => false,
            'maintenance_message' => 'We are currently performing scheduled maintenance. Please check back soon.',
            'maintenance_scheduled_at' => null,
            'maintenance_scheduled_until' => null,
            'footer_text' => 'Thank you for shopping with us!',
            'copyright_notice' => '© ' . date('Y') . ' tutionmediabd. All rights reserved.',
            'primary_color' => '#F59E0B',
            'secondary_color' => '#1E293B',
            'accent_color' => '#EF4444',
            'google_analytics_id' => null,
            'custom_css' => null,
            'custom_js' => null,
            'email_notification_preferences' => [
                'order_placed' => true,
                'order_shipped' => true,
                'order_delivered' => true,
                'new_customer' => true,
                'low_stock' => true,
            ],
        ]);

        $this->command->info('Site settings seeded successfully!');
    }
}
