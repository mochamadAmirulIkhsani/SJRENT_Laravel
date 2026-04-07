<?php

namespace App\Helpers;

use App\Models\CompanySetting;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class SEOHelper
{
    protected CompanySetting $settings;

    public function __construct()
    {
        $this->settings = CompanySetting::getInstance();
    }

    public function setDefaults(): void
    {
        SEOMeta::setTitle($this->settings->meta_title ?? $this->settings->company_name);
        SEOMeta::setDescription($this->settings->meta_description ?? '');
        SEOMeta::setCanonical(url()->current());
        
        OpenGraph::setTitle($this->settings->meta_title ?? $this->settings->company_name);
        OpenGraph::setDescription($this->settings->meta_description ?? '');
        OpenGraph::setUrl(url()->current());
        OpenGraph::setSiteName($this->settings->company_name);
        
        TwitterCard::setType('summary_large_image');
    }

    public function setPage(string $title, string $description, ?string $image = null): void
    {
        $fullTitle = $title . ' | ' . $this->settings->company_name;
        SEOMeta::setTitle($fullTitle);
        SEOMeta::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        
        if ($image) {
            OpenGraph::addImage($image);
            TwitterCard::setImage($image);
        }
    }

    public function localBusinessSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $this->settings->company_name,
            'description' => $this->settings->description,
            'url' => url('/'),
            'telephone' => $this->settings->phone,
            'email' => $this->settings->email,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->settings->address,
                'addressLocality' => 'Malang',
                'addressRegion' => 'Jawa Timur',
                'addressCountry' => 'ID',
            ],
        ];
    }

    public static function renderSchema(array $schema): string
    {
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
