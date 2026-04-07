<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Helpers\SEOHelper;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::getInstance();
        
        $seo = new SEOHelper();
        $seo->setPage(
            'Tentang Kami',
            'Kenali lebih dekat SJRent - penyedia layanan rental motor terpercaya di Malang dengan armada lengkap dan pelayanan terbaik.'
        );
        
        return view('pages.about', compact('settings'));
    }
}
