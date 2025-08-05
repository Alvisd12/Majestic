<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published()->with('admin');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }
        
        $wisata = $query->orderBy('created_at', 'desc')->paginate(5);
        
        return view('wisata.index', compact('wisata'));
    }
    
    public function show($id)
    {
        $wisata = Blog::published()->with('admin')->findOrFail($id);
        
        // Get related wisata (other published blogs)
        $relatedWisata = Blog::published()
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();
        
        return view('wisata.show', compact('wisata', 'relatedWisata'));
    }
}