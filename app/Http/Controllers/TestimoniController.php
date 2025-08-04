<?php
// app/Http/Controllers/TestimoniController.php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function create()
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        
        // Cek apakah user sudah pernah memberikan testimoni
        $existingTestimoni = Testimoni::where('id_pengunjung', $user->id)->first();
        
        return view('testimoni.create', compact('existingTestimoni'));
    }
    
    public function store(Request $request)
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        
        // Cek apakah user sudah pernah memberikan testimoni
        $existingTestimoni = Testimoni::where('id_pengunjung', $user->id)->first();
        
        if ($existingTestimoni) {
            return redirect()->back()->with('error', 'Anda sudah memberikan testimoni sebelumnya.');
        }
        
        $validated = $request->validate([
            'pesan' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'pesan.required' => 'Pesan testimoni wajib diisi.',
            'pesan.min' => 'Pesan testimoni minimal 10 karakter.',
            'pesan.max' => 'Pesan testimoni maksimal 500 karakter.',
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
        ]);
        
        Testimoni::create([
            'id_pengunjung' => $user->id,
            'nama' => $user->nama,
            'pesan' => $validated['pesan'],
            'rating' => $validated['rating'],
            'approved' => false, // Menunggu persetujuan admin
        ]);
        
        return redirect()->route('testimoni.public')
            ->with('success', 'Testimoni berhasil dikirim! Menunggu persetujuan admin.');
    }
    
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
    
    public function edit($id)
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        $testimoni = Testimoni::findOrFail($id);
        
        // Cek apakah user berhak mengedit testimoni ini
        if (!AuthController::isAdmin() && $testimoni->id_pengunjung !== $user->id) {
            abort(403, 'Anda tidak berhak mengedit testimoni ini.');
        }
        
        // Tidak bisa edit jika testimoni sudah disetujui (kecuali admin)
        if ($testimoni->approved && !AuthController::isAdmin()) {
            return redirect()->back()->with('error', 'Testimoni yang sudah disetujui tidak dapat diubah.');
        }
        
        return view('testimoni.edit', compact('testimoni'));
    }
    
    public function update(Request $request, $id)
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        $testimoni = Testimoni::findOrFail($id);
        
        // Cek apakah user berhak mengupdate testimoni ini
        if (!AuthController::isAdmin() && $testimoni->id_pengunjung !== $user->id) {
            abort(403, 'Anda tidak berhak mengupdate testimoni ini.');
        }
        
        $validated = $request->validate([
            'pesan' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        // Jika bukan admin dan testimoni sudah disetujui, set approved ke false lagi
        if (!AuthController::isAdmin() && $testimoni->approved) {
            $validated['approved'] = false;
        }
        
        $testimoni->update($validated);
        
        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        AuthController::requireAuth();
        
        $user = AuthController::getCurrentUser();
        $testimoni = Testimoni::findOrFail($id);
        
        // Cek apakah user berhak menghapus testimoni ini
        if (!AuthController::isAdmin() && $testimoni->id_pengunjung !== $user->id) {
            abort(403, 'Anda tidak berhak menghapus testimoni ini.');
        }
        
        $testimoni->delete();
        
        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni berhasil dihapus!');
    }
}