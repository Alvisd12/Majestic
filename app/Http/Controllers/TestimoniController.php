<?php
// app/Http/Controllers/TestimoniController.php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        
        // Jika admin, tampilkan semua testimoni
        if (AuthController::isAdmin()) {
            $testimoni = Testimoni::with('pengunjung')->latest()->paginate(10);
        } else {
            // Jika pengunjung, tampilkan hanya testimoni miliknya
            $testimoni = Testimoni::where('id_pengunjung', $user->id)->latest()->paginate(10);
        }
        
        return view('testimoni.index', compact('testimoni'));
    }
    
    public function show($id)
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        $testimoni = Testimoni::with('pengunjung')->findOrFail($id);
        
        // Cek apakah user berhak melihat testimoni ini
        if (!AuthController::isAdmin() && $testimoni->id_pengunjung !== $user->id) {
            abort(403, 'Anda tidak berhak melihat testimoni ini.');
        }
        
        return view('testimoni.show', compact('testimoni'));
    }
}
