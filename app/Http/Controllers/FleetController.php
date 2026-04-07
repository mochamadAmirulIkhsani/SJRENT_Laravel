<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\Category;
use App\Helpers\SEOHelper;
use Illuminate\Http\Request;

class FleetController extends Controller
{
    public function index(Request $request)
    {
        $query = Motorcycle::with('category');
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $motorcycles = $query->paginate(12);
        $categories = Category::all();
        
        $seo = new SEOHelper();
        $seo->setPage(
            'Armada Motor Kami',
            'Lihat koleksi lengkap motor rental kami di Malang. Tersedia berbagai jenis motor matic, sport, dan bebek dengan harga terjangkau.'
        );
        
        return view('pages.fleet.index', compact('motorcycles', 'categories'));
    }
    
    public function show($slug)
    {
        $motorcycle = Motorcycle::where('slug', $slug)
            ->with('category')
            ->firstOrFail();
        
        $seo = new SEOHelper();
        $seo->setPage(
            $motorcycle->name,
            "Rental {$motorcycle->name} di Malang. Harga Rp " . number_format($motorcycle->price_per_day, 0, ',', '.') . "/hari.",
            $motorcycle->image ? asset('storage/' . $motorcycle->image) : null
        );
        
        return view('pages.fleet.show', compact('motorcycle'));
    }
}
