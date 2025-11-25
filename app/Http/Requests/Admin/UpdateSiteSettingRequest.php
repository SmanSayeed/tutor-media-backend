<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only allow admin users
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currencies = ['USD', 'EUR', 'GBP', 'BDT', 'INR', 'PKR', 'AED', 'SAR'];
        $languages = ['en', 'bn', 'ar', 'hi', 'ur', 'fr', 'de', 'es'];
        $timezones = timezone_identifiers_list();

        return [
            // Website Information
            'website_name' => ['required', 'string', 'max:255'],
            'website_tagline' => ['nullable', 'string', 'max:255'],
            'website_description' => ['nullable', 'string', 'max:1000'],

            // Logo and Favicon
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,ico', 'max:1024'],

            // Contact Information
            'primary_email' => ['nullable', 'email', 'max:255'],
            'secondary_email' => ['nullable', 'email', 'max:255'],
            'primary_phone' => ['nullable', 'string', 'max:20'],
            'secondary_phone' => ['nullable', 'string', 'max:20'],
            'physical_address' => ['nullable', 'string', 'max:500'],
            'business_hours' => ['nullable', 'string', 'max:500'],

            // Social Media Links
            'social_media_links.facebook' => ['nullable', 'url', 'max:255'],
            'social_media_links.twitter' => ['nullable', 'url', 'max:255'],
            'social_media_links.instagram' => ['nullable', 'url', 'max:255'],
            'social_media_links.linkedin' => ['nullable', 'url', 'max:255'],
            'social_media_links.youtube' => ['nullable', 'url', 'max:255'],
            'social_media_links.tiktok' => ['nullable', 'url', 'max:255'],

            // Localization
            'default_currency' => ['required', 'string', Rule::in($currencies)],
            'default_language' => ['required', 'string', Rule::in($languages)],
            'supported_languages' => ['nullable', 'array'],
            'supported_languages.*' => ['string', Rule::in($languages)],
            'timezone' => ['required', 'string', Rule::in($timezones)],

            // SEO Settings
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'canonical_url' => ['nullable', 'url', 'max:500'],

            // Maintenance Mode
            'maintenance_mode' => ['nullable', 'boolean'],
            'maintenance_message' => ['nullable', 'string', 'max:1000'],
            'maintenance_scheduled_at' => ['nullable', 'date'],
            'maintenance_scheduled_until' => ['nullable', 'date', 'after:maintenance_scheduled_at'],

            // Additional Settings
            'footer_text' => ['nullable', 'string', 'max:1000'],
            'copyright_notice' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'accent_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'custom_css' => ['nullable', 'string', 'max:10000'],
            'custom_js' => ['nullable', 'string', 'max:10000'],
            'email_notification_preferences' => ['nullable', 'array'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'website_name.required' => 'Website name is required.',
            'logo.image' => 'Logo must be an image file.',
            'logo.mimes' => 'Logo must be a PNG, JPG, JPEG, SVG, or WEBP file.',
            'logo.max' => 'Logo size must not exceed 2MB.',
            'favicon.image' => 'Favicon must be an image file.',
            'favicon.mimes' => 'Favicon must be a PNG, JPG, JPEG, SVG, or ICO file.',
            'favicon.max' => 'Favicon size must not exceed 1MB.',
            'primary_email.email' => 'Primary email must be a valid email address.',
            'social_media_links.*.url' => 'Social media links must be valid URLs.',
            'default_currency.in' => 'Please select a valid currency.',
            'default_language.in' => 'Please select a valid language.',
            'timezone.in' => 'Please select a valid timezone.',
            'primary_color.regex' => 'Primary color must be a valid hex color code.',
            'secondary_color.regex' => 'Secondary color must be a valid hex color code.',
            'accent_color.regex' => 'Accent color must be a valid hex color code.',
            'maintenance_scheduled_until.after' => 'Maintenance end time must be after start time.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Convert maintenance_mode checkbox to boolean
        if (!$this->has('maintenance_mode')) {
            $this->merge(['maintenance_mode' => false]);
        } else {
            $this->merge(['maintenance_mode' => (bool) $this->maintenance_mode]);
        }
    }
}
