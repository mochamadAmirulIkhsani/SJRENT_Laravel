<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_photo',
        'rating',
        'review_text',
        'is_approved',
        'display_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get only approved testimonials ordered by display_order
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)
                    ->orderBy('display_order')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get testimonials for public display (approved and ordered)
     */
    public static function getForPublicDisplay(?int $limit = null)
    {
        $query = self::approved();
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    /**
     * Get star rating as HTML
     */
    public function getStarsHtml(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }
}
