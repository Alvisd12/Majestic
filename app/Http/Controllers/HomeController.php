<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Testimoni;
use App\Models\Blog;
use App\Models\Galeri;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data untuk homepage
        $motors = Motor::tersedia()->take(6)->get();
        $testimoni = Testimoni::approved()->with('pengunjung')->take(6)->latest()->get();
        $blogs = Blog::published()->take(3)->latest()->get();
        $galeri = Galeri::take(8)->latest()->get();
        
        $stats = [
            'total_motor' => Motor::count(),
            'motor_tersedia' => Motor::tersedia()->count(),
            'total_pengunjung' => \App\Models\Pengunjung::count(),
            'total_peminjaman' => \App\Models\Peminjaman::where('status', 'Selesai')->count(),
        ];
        
        return view('home.dashboard', compact('motors', 'testimoni', 'blogs', 'galeri', 'stats'));
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function services()
    {
        return view('services');
    }
    
    public function motors(Request $request)
    {
        $query = Motor::query();
        
        // Filter by availability
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by merk
        if ($request->has('merk') && $request->merk) {
            $query->where('merk', $request->merk);
        }
        
        // Filter by price range
        if ($request->has('min_harga') && $request->min_harga) {
            $query->where('harga_per_hari', '>=', $request->min_harga);
        }
        
        if ($request->has('max_harga') && $request->max_harga) {
            $query->where('harga_per_hari', '<=', $request->max_harga);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('merk', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }
        
        $motors = $query->paginate(12);
        $merks = Motor::distinct()->pluck('merk');
        
        return view('motors', compact('motors', 'merks'));
    }
    
    public function testimoni()
    {
        $testimoni = Testimoni::approved()->with('pengunjung')->latest()->paginate(10);
        
        return view('testimoni', compact('testimoni'));
    }
    
    public function contact()
    {
        return view('contact');
    }
}