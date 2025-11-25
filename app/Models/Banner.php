<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'image',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the URL for the banner image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/placeholder.png');
        }
        
        // Check if the path already contains the full URL or just the filename
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Check if the path already includes the directory
        if (strpos($this->image, 'images/banner/') === 0) {
            return asset($this->image);
        }
        
        return asset('images/banner/' . $this->image);
    }
}
