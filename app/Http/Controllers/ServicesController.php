<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Helpers\SEOHelper;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::getInstance();
        
        $seo = new SEOHelper();
        $seo->setPage(
            'Layanan Kami',
            'Berbagai paket rental motor yang fleksibel: harian, mingguan, bulanan dengan harga terjangkau. Proses mudah dan cepat.'
        );
        
        return view('pages.services', compact('settings'));
    }
}
