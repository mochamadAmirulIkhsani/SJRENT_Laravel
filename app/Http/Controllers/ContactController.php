<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Helpers\SEOHelper;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::getInstance();
        
        $seo = new SEOHelper();
        $seo->setPage(
            'Hubungi Kami',
            'Hubungi SJRent untuk rental motor di Malang. Kami siap melayani kebutuhan transportasi Anda dengan layanan terbaik.'
        );
        
        return view('pages.contact', compact('settings'));
    }
    
    public function submit(Request $request)
    {
        // This will be implemented later with email functionality
        // For now, just redirect back with success message
        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
