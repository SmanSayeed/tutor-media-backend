<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SiteSettingController extends Controller
{
    /**
     * Display the site settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = SiteSetting::getSettings();
        
        return view('admin.site-settings.index', compact('settings'));
    }

    /**
     * Update site settings.
     *
     * @param UpdateSiteSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSiteSettingRequest $request)
    {
        try {
            DB::beginTransaction();

            $settings = SiteSetting::getSettings();
            $data = $request->validated();

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $oldLogo = $settings->logo_path;
                $logoPath = $this->handleImageUpload($request->file('logo'), 'logos', 300, 300);
                $data['logo_path'] = $logoPath;
                
                // Delete old logo from public disk
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                $oldFavicon = $settings->favicon_path;
                $faviconPath = $this->handleImageUpload($request->file('favicon'), 'favicons', 32, 32);
                $data['favicon_path'] = $faviconPath;
                
                // Delete old favicon from public disk
                if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                    Storage::disk('public')->delete($oldFavicon);
                }
            }

            // Handle OG image upload
            if ($request->hasFile('og_image')) {
                $oldOgImage = $settings->og_image;
                $ogImagePath = $this->handleImageUpload($request->file('og_image'), 'og-images', 1200, 630);
                $data['og_image'] = $ogImagePath;
                
                // Delete old OG image from public disk
                if ($oldOgImage && Storage::disk('public')->exists($oldOgImage)) {
                    Storage::disk('public')->delete($oldOgImage);
                }
            }

            // Remove file inputs from data array if not present
            unset($data['logo'], $data['favicon'], $data['og_image']);

            // Update settings
            $settings->update($data);

            // Explicitly clear cache to ensure fresh data
            SiteSetting::clearCache();

            // Log the change
            Log::info('Site settings updated', [
                'user_id' => auth()->id(),
                'changes' => array_keys($data),
            ]);

            DB::commit();

            return redirect()->route('admin.site-settings.index')
                ->with('success', 'Site settings updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to update site settings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update site settings. Please try again.')
                ->withInput();
        }
    }

    /**
     * Handle image upload with resizing and optimization.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param int|null $width
     * @param int|null $height
     * @return string
     */
    private function handleImageUpload($file, string $folder, ?int $width = null, ?int $height = null): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "site-settings/{$folder}/{$filename}";

        // Handle SVG files differently (no resizing)
        if ($file->getClientOriginalExtension() === 'svg') {
            Storage::disk('public')->putFileAs("site-settings/{$folder}", $file, $filename);
            return $path;
        }

        // Resize and optimize image using Intervention Image v3
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        if ($width && $height) {
            $image->cover($width, $height);
        }

        // Create a temporary file path
        $tempPath = sys_get_temp_dir() . '/' . uniqid('img_', true) . '.' . $file->getClientOriginalExtension();
        
        // Save the image to temporary location with quality
        $image->save($tempPath, 90);
        
        // Read the processed image content
        $imageContent = file_get_contents($tempPath);
        
        // Store the image in Storage using the 'public' disk explicitly
        Storage::disk('public')->put($path, $imageContent);
        
        // Clean up temporary file
        if (file_exists($tempPath)) {
            @unlink($tempPath);
        }

        return $path;
    }

    /**
     * Delete logo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteLogo()
    {
        try {
            $settings = SiteSetting::getSettings();
            
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $settings->update(['logo_path' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Logo deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete logo.',
            ], 500);
        }
    }

    /**
     * Delete favicon.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFavicon()
    {
        try {
            $settings = SiteSetting::getSettings();
            
            if ($settings->favicon_path && Storage::disk('public')->exists($settings->favicon_path)) {
                Storage::disk('public')->delete($settings->favicon_path);
            }

            $settings->update(['favicon_path' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Favicon deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete favicon.',
            ], 500);
        }
    }

    /**
     * Delete OG image.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOgImage()
    {
        try {
            $settings = SiteSetting::getSettings();
            
            if ($settings->og_image && Storage::disk('public')->exists($settings->og_image)) {
                Storage::disk('public')->delete($settings->og_image);
            }

            $settings->update(['og_image' => null]);

            return response()->json([
                'success' => true,
                'message' => 'OG image deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete OG image.',
            ], 500);
        }
    }

    /**
     * Toggle maintenance mode.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleMaintenanceMode(Request $request)
    {
        try {
            $settings = SiteSetting::getSettings();
            $settings->update([
                'maintenance_mode' => !$settings->maintenance_mode,
            ]);

            return response()->json([
                'success' => true,
                'maintenance_mode' => $settings->maintenance_mode,
                'message' => $settings->maintenance_mode 
                    ? 'Maintenance mode enabled.' 
                    : 'Maintenance mode disabled.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle maintenance mode.',
            ], 500);
        }
    }
}
