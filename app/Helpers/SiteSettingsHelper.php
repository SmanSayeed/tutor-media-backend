<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingsHelper
{
    /**
     * Get a specific setting value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $settings = static::all();
        return $settings->$key ?? $default;
    }

    /**
     * Get all site settings.
     *
     * @return SiteSetting
     */
    public static function all(): SiteSetting
    {
        try {
            return SiteSetting::getSettings();
        } catch (\Exception $e) {
            // Log error and try to get from database directly
            \Illuminate\Support\Facades\Log::error('Error loading site settings: ' . $e->getMessage());
            try {
                // Try to get from database directly without cache
                \Illuminate\Support\Facades\Cache::forget('site_settings');
                return SiteSetting::firstOrCreate([], [
                    'website_name' => 'Tutor Media',
                    'default_currency' => 'BDT',
                    'default_language' => 'en',
                    'timezone' => 'Asia/Dhaka',
                    'primary_color' => '#F59E0B',
                    'secondary_color' => '#1E293B',
                    'accent_color' => '#EF4444',
                ]);
            } catch (\Exception $e2) {
                // Last resort: return a minimal instance
                \Illuminate\Support\Facades\Log::error('Critical error loading site settings: ' . $e2->getMessage());
                $settings = new SiteSetting();
                $settings->setRawAttributes([
                    'website_name' => 'Tutor Media',
                    'default_currency' => 'BDT',
                    'default_language' => 'en',
                    'timezone' => 'Asia/Dhaka',
                ]);
                return $settings;
            }
        }
    }

    /**
     * Get website name.
     *
     * @return string
     */
    public static function websiteName(): string
    {
        return static::get('website_name', 'tutionmediabd');
    }

    /**
     * Get logo URL.
     *
     * @return string|null
     */
    public static function logoUrl(): ?string
    {
        try {
            $settings = static::all();
            return $settings->logo_url ?? null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting logo URL: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get favicon URL.
     *
     * @return string|null
     */
    public static function faviconUrl(): ?string
    {
        try {
            $settings = static::all();
            return $settings->favicon_url ?? null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting favicon URL: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get primary email.
     *
     * @return string|null
     */
    public static function primaryEmail(): ?string
    {
        return static::get('primary_email');
    }

    /**
     * Get primary phone.
     *
     * @return string|null
     */
    public static function primaryPhone(): ?string
    {
        return static::get('primary_phone');
    }

    /**
     * Get secondary email.
     *
     * @return string|null
     */
    public static function secondaryEmail(): ?string
    {
        return static::get('secondary_email');
    }

    /**
     * Get secondary phone.
     *
     * @return string|null
     */
    public static function secondaryPhone(): ?string
    {
        return static::get('secondary_phone');
    }

    /**
     * Get physical address.
     *
     * @return string|null
     */
    public static function physicalAddress(): ?string
    {
        return static::get('physical_address');
    }

    /**
     * Get business hours.
     *
     * @return string|null
     */
    public static function businessHours(): ?string
    {
        return static::get('business_hours');
    }

    /**
     * Get footer text.
     *
     * @return string|null
     */
    public static function footerText(): ?string
    {
        return static::get('footer_text');
    }

    /**
     * Get copyright notice.
     *
     * @return string|null
     */
    public static function copyrightNotice(): ?string
    {
        return static::get('copyright_notice');
    }

    /**
     * Get tagline.
     *
     * @return string|null
     */
    public static function tagline(): ?string
    {
        return static::get('website_tagline');
    }

    /**
     * Get primary color.
     *
     * @return string
     */
    public static function primaryColor(): string
    {
        return static::get('primary_color', '#F59E0B');
    }

    /**
     * Get secondary color.
     *
     * @return string
     */
    public static function secondaryColor(): string
    {
        return static::get('secondary_color', '#1E293B');
    }

    /**
     * Get accent color.
     *
     * @return string
     */
    public static function accentColor(): string
    {
        return static::get('accent_color', '#EF4444');
    }

    /**
     * Get social media links.
     *
     * @return array
     */
    public static function socialLinks(): array
    {
        return static::get('social_media_links', []);
    }

    /**
     * Get default currency.
     *
     * @return string
     */
    public static function defaultCurrency(): string
    {
        return static::get('default_currency', 'BDT');
    }

    /**
     * Get default language.
     *
     * @return string
     */
    public static function defaultLanguage(): string
    {
        return static::get('default_language', 'en');
    }

    /**
     * Check if maintenance mode is enabled.
     *
     * @return bool
     */
    public static function isMaintenanceMode(): bool
    {
        return static::get('maintenance_mode', false);
    }

    /**
     * Get maintenance message.
     *
     * @return string|null
     */
    public static function maintenanceMessage(): ?string
    {
        return static::get('maintenance_message');
    }

    /**
     * Get Google Analytics ID.
     *
     * @return string|null
     */
    public static function googleAnalyticsId(): ?string
    {
        return static::get('google_analytics_id');
    }

    /**
     * Get custom CSS.
     *
     * @return string|null
     */
    public static function customCss(): ?string
    {
        return static::get('custom_css');
    }

    /**
     * Get custom JavaScript.
     *
     * @return string|null
     */
    public static function customJs(): ?string
    {
        return static::get('custom_js');
    }

    /**
     * Get meta title.
     *
     * @return string|null
     */
    public static function metaTitle(): ?string
    {
        return static::get('meta_title');
    }

    /**
     * Get meta description.
     *
     * @return string|null
     */
    public static function metaDescription(): ?string
    {
        return static::get('meta_description');
    }

    /**
     * Get meta keywords.
     *
     * @return string|array|null
     */
    public static function metaKeywords()
    {
        $keywords = static::get('meta_keywords');
        if (is_array($keywords)) {
            return $keywords;
        }
        if (is_string($keywords) && !empty($keywords)) {
            // If it's a comma-separated string, return as array
            return array_map('trim', explode(',', $keywords));
        }
        return $keywords;
    }

    /**
     * Get OG image URL.
     *
     * @return string|null
     */
    public static function ogImageUrl(): ?string
    {
        return static::all()->og_image_url;
    }
}

