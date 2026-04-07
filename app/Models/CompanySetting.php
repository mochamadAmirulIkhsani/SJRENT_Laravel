<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'company_name',
        'tagline',
        'description',
        'address',
        'phone',
        'email',
        'whatsapp',
        'coordinates_lat',
        'coordinates_lng',
        'business_hours',
        'social_media',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'why_choose_us',
        'faqs',
        'logo',
        'favicon',
    ];

    protected $casts = [
        'business_hours' => 'array',
        'social_media' => 'array',
        'why_choose_us' => 'array',
        'faqs' => 'array',
        'coordinates_lat' => 'decimal:8',
        'coordinates_lng' => 'decimal:8',
    ];

    /**
     * Get the singleton instance of company settings.
     * Creates a default record if none exists.
     */
    public static function getInstance(): self
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'company_name' => 'SJRent',
                'tagline' => 'Rental Motor Terpercaya di Malang',
                'description' => 'SJRent adalah layanan rental motor terpercaya di Malang, Jawa Timur.',
                'meta_title' => 'SJRent - Rental Motor Malang Terpercaya',
                'meta_description' => 'Rental motor murah dan terpercaya di Malang. Tersedia berbagai jenis motor matic, sport, bebek dengan harga terjangkau.',
            ]);
        }
        
        return $settings;
    }

    /**
     * Get formatted business hours for display
     */
    public function getFormattedBusinessHours(): string
    {
        if (!$this->business_hours) {
            return 'Senin - Minggu: 08:00 - 17:00';
        }

        return collect($this->business_hours)
            ->map(fn($hours, $day) => ucfirst($day) . ': ' . $hours)
            ->join(', ');
    }

    /**
     * Get WhatsApp link with optional message
     */
    public function getWhatsAppLink(?string $message = null): string
    {
        if (!$this->whatsapp) {
            return '#';
        }

        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        $defaultMessage = 'Halo, saya tertarik dengan layanan rental motor di SJRent.';
        $text = urlencode($message ?? $defaultMessage);

        return "https://wa.me/{$number}?text={$text}";
    }
}
