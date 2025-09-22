<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Testimoni;
use App\Models\Blog;
use App\Models\Galeri;
use App\Models\Peminjaman;
use App\Models\General;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data untuk homepage
        $motors = Motor::tersedia()->take(6)->get();
        $testimoni = Testimoni::approved()->with('pengunjung')->take(6)->latest()->get();
        $blogs = Blog::where('published', true)->take(6)->latest()->get();
        $galeri = Galeri::take(8)->latest()->get();
        
        $stats = [
            'total_motor' => Motor::count(),
            'motor_tersedia' => Motor::tersedia()->count(),
            'total_pengunjung' => \App\Models\Pengunjung::count(),
            'total_peminjaman' => Peminjaman::completed()->count(),
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
    
    public function motorDetail($id)
    {
        $motor = Motor::findOrFail($id);
        $relatedMotors = Motor::where('id', '!=', $id)
            ->where('merk', $motor->merk)
            ->tersedia()
            ->take(3)
            ->get();
        $general = General::getSingle();
        
        // Get current rental for this motor if it's not available, or latest completed rental with penalty
        $currentRental = null;
        if ($motor->status !== 'Tersedia') {
            $currentRental = Peminjaman::where('motor_id', $id)
                ->where(function($q) {
                    $q->whereIn('status', ['Dikonfirmasi', 'Sedang Disewa'])
                      ->orWhere('status', 'like', 'Terlambat%')
                      // Legacy support
                      ->orWhereIn('status', ['Confirmed', 'Belum Kembali', 'Disewa']);
                })
                ->with('user')
                ->first();
            
            // Update penalty if rental exists and is overdue
            if ($currentRental && ($currentRental->isOverdue || str_starts_with($currentRental->status, 'Terlambat'))) {
                $currentRental->updateDenda();
                $currentRental->refresh(); // Refresh to get updated denda value
            }
        } else {
            // Check for recently completed rental with penalty (for display purposes)
            $currentRental = Peminjaman::where('motor_id', $id)
                ->where('status', 'like', 'Selesai (Telat%')
                ->where('denda', '>', 0)
                ->with('user')
                ->orderBy('updated_at', 'desc')
                ->first();
        }
            
        return view('home.motor-detail', compact('motor', 'relatedMotors', 'general', 'currentRental'));
    }
    
    public function hargaSewa()
    {
        $motors = Motor::all();
        return view('home.harga_sewa', compact('motors'));
    }
    
    public function galeri()
    {
        $galeri = Galeri::latest()->paginate(12);
        return view('home.galeri', compact('galeri'));
    }
    
    public function testimoni()
    {
        $testimoni = Testimoni::approved()->with('pengunjung')->latest()->paginate(10);
        
        return view('testimoni', compact('testimoni'));
    }
    
    public function kontak()
    {
        // Get approved testimonials for display
        $testimoni = Testimoni::approved()->latest()->take(6)->get();
        
        return view('home.kontak', compact('testimoni'));
    }
    
    public function contact()
    {
        return view('contact');
    }
}