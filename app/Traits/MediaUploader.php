<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Trait MediaUploader
 *
 * Provides utility methods for handling file uploads, deletions,
 * and retrieving full file paths using Laravel's storage system.
 *
 * @author Md Safiullah
 *
 * @version 1.0
 *
 * @methods
 *  upload(mixed $file, string $path = 'others'): string
 *      Uploads the given file to the specified storage path and returns the file's storage path.
 *  delete(string $path): bool
 *      Deletes the file at the specified path from storage.
 *  getFullPath(string $path): string
 *      Retrieves the full public URL for the file located at the given storage path.
 *
 * @created 2024-09-04
 */
trait MediaUploader
{
    private static $base_path = '/frontend-uploads/';

    /**
     * Store the file in the storage
     *
     * @param  mixed  $file  The file to be uploaded
     * @param  string  $path  The path where the file will be stored. Default is 'others'
     * @return string The full path of the uploaded file
     */
    public function upload(mixed $file, string $path = 'others'): string
    {
        // optimize image if file is image
        optimizeImage($file);

        // Generate a random file name
        $file_name = random_int(1000, 9999).'-'.time().'-'.random_int(1000, 9999).'-'.$file->getClientOriginalName();

        // Get the storage disk
        $storage = Storage::disk('public');

        // Set the full path where the file will be stored
        // Example: uploads/service/08-02-2022/5451545-example.png
        $full_path = self::$base_path.$path.'/'.Carbon::now()->format('d-m-Y').'/';

        // Check if the directory where the file will be stored exists
        // If it doesn't exist, create it
        if (! $storage->exists($full_path)) {
            $storage->makeDirectory($full_path);
        }

        // Store the file in the specified path
        $storage->putFileAs($full_path, $file, $file_name);

        // Return the full path of the uploaded file
        return '/storage'.$full_path.$file_name;
    }

    /**
     * Delete the file from the storage
     */
    public function delete($path)
    {
        $storage = Storage::disk('public');

        if ($storage->exists($path)) {
            return $storage->delete($path);
        }

        return false;
    }

    /**
     * Get the full path
     */
    public function getFullPath($path)
    {
        return Storage::disk('public')->url($path);
    }
}
