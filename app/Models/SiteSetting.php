<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'website_name',
        'website_tagline',
        'website_description',
        'logo_path',
        'favicon_path',
        'primary_email',
        'secondary_email',
        'primary_phone',
        'secondary_phone',
        'physical_address',
        'business_hours',
        'social_media_links',
        'default_currency',
        'default_language',
        'supported_languages',
        'timezone',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'maintenance_mode',
        'maintenance_message',
        'maintenance_scheduled_at',
        'maintenance_scheduled_until',
        'footer_text',
        'copyright_notice',
        'primary_color',
        'secondary_color',
        'accent_color',
        'google_analytics_id',
        'custom_css',
        'custom_js',
        'email_notification_preferences',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'social_media_links' => 'array',
        'supported_languages' => 'array',
        'email_notification_preferences' => 'array',
        'maintenance_mode' => 'boolean',
        'maintenance_scheduled_at' => 'datetime',
        'maintenance_scheduled_until' => 'datetime',
    ];

    /**
     * Get the logo URL.
     *
     * @return string|null
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->logo_path);
    }

    /**
     * Get the favicon URL.
     *
     * @return string|null
     */
    public function getFaviconUrlAttribute(): ?string
    {
        if (!$this->favicon_path) {
            return null;
        }

        return Storage::disk('public')->url($this->favicon_path);
    }

    /**
     * Get the OG image URL.
     *
     * @return string|null
     */
    public function getOgImageUrlAttribute(): ?string
    {
        if (!$this->og_image) {
            return null;
        }

        return Storage::disk('public')->url($this->og_image);
    }

    /**
     * Mutator for social media links - ensure valid URLs
     *
     * @param mixed $value
     * @return void
     */
    public function setSocialMediaLinksAttribute($value): void
    {
        if (is_array($value)) {
            // Filter out empty values and validate URLs
            $filtered = [];
            foreach ($value as $key => $url) {
                if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                    $filtered[$key] = $url;
                }
            }
            $this->attributes['social_media_links'] = json_encode($filtered);
        } else {
            $this->attributes['social_media_links'] = $value;
        }
    }

    /**
     * Mutator for supported languages - ensure array format
     *
     * @param mixed $value
     * @return void
     */
    public function setSupportedLanguagesAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['supported_languages'] = json_encode(array_filter($value));
        } else {
            $this->attributes['supported_languages'] = $value;
        }
    }

    /**
     * Get or create the site settings singleton instance.
     *
     * @return self
     */
    public static function getSettings(): self
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::firstOrCreate([], [
                'website_name' => 'tutionmediabd',
                'default_currency' => 'BDT',
                'default_language' => 'en',
                'timezone' => 'Asia/Dhaka',
                'primary_color' => '#F59E0B',
                'secondary_color' => '#1E293B',
                'accent_color' => '#EF4444',
            ]);
        });
    }

    /**
     * Clear the settings cache.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget('site_settings');
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        // Clear cache on save/update/delete
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
