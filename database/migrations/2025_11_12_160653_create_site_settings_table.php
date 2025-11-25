<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            
            // Website Information
            $table->string('website_name')->default('tutionmediabd');
            $table->string('website_tagline')->nullable();
            $table->text('website_description')->nullable();
            
            // Logo and Favicon
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            
            // Contact Information
            $table->string('primary_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->text('physical_address')->nullable();
            $table->text('business_hours')->nullable();
            
            // Social Media Links (stored as JSON)
            $table->json('social_media_links')->nullable();
            
            // Localization
            $table->string('default_currency', 3)->default('BDT');
            $table->string('default_language', 10)->default('en');
            $table->json('supported_languages')->nullable();
            $table->string('timezone')->default('Asia/Dhaka');
            
            // SEO Settings
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->text('canonical_url')->nullable();
            
            // Maintenance Mode
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->timestamp('maintenance_scheduled_at')->nullable();
            $table->timestamp('maintenance_scheduled_until')->nullable();
            
            // Additional Settings
            $table->text('footer_text')->nullable();
            $table->string('copyright_notice')->nullable();
            $table->string('primary_color')->default('#F59E0B'); // Amber
            $table->string('secondary_color')->default('#1E293B'); // Slate
            $table->string('accent_color')->default('#EF4444'); // Red
            $table->string('google_analytics_id')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->json('email_notification_preferences')->nullable();
            
            // Audit Trail
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('maintenance_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
