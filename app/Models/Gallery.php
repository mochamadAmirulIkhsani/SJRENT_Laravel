<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'alt_text',
        'description',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];

    /**
     * Get images by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category)
                    ->orderBy('display_order')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get company photos
     */
    public static function getCompanyPhotos()
    {
        return self::byCategory('company')->get();
    }

    /**
     * Get fleet photos
     */
    public static function getFleetPhotos()
    {
        return self::byCategory('fleet')->get();
    }

    /**
     * Get facilities photos
     */
    public static function getFacilitiesPhotos()
    {
        return self::byCategory('facilities')->get();
    }

    /**
     * Get full image URL
     */
    public function getImageUrl(): string
    {
        return Storage::url($this->image_path);
    }

    /**
     * Delete image file when model is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($gallery) {
            if ($gallery->image_path && Storage::exists($gallery->image_path)) {
                Storage::delete($gallery->image_path);
            }
        });
    }
}
