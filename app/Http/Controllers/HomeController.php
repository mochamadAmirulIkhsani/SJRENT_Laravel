<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\Testimonial;
use App\Models\Motorcycle;
use App\Helpers\SEOHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::getInstance();
        $testimonials = Testimonial::getForPublicDisplay(6);
        $motorcycles = Motorcycle::where('status', Motorcycle::STATUS_AVAILABLE)
            ->with('category')
            ->latest()
            ->take(4)
            ->get();
        
        $seo = new SEOHelper();
        $seo->setDefaults();
        
        return view('pages.home', compact('settings', 'testimonials', 'motorcycles'));
    }
}
