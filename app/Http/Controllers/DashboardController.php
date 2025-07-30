<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Peminjaman;
use App\Models\Pengunjung;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user data from session instead of Auth facade
        $userRole = session('user_role');
        $userId = session('user_id');
        $userName = session('user_name');
        
        // Create user object from session data
        $user = (object) [
            'id' => $userId,
            'nama' => $userName,
            'role' => $userRole
        ];
        
        // Statistik untuk user
        $stats = [
            'total_peminjaman' => Peminjaman::where('user_id', $userId)->count(),
            'peminjaman_aktif' => Peminjaman::where('user_id', $userId)
                ->whereIn('status', ['Confirmed', 'Disewa'])
                ->count(),
            'peminjaman_selesai' => Peminjaman::where('user_id', $userId)
                ->where('status', 'Selesai')
                ->count(),
            'motor_tersedia' => Motor::where('status', 'Tersedia')->count(),
        ];
        
        // Peminjaman terbaru
        $recentPeminjaman = Peminjaman::where('user_id', $userId)
            ->with('motor')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Motor populer/tersedia
        $availableMotor = Motor::where('status', 'Tersedia')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        return view('dashboard.index', compact(
            'user', 
            'stats', 
            'recentPeminjaman', 
            'availableMotor'
        ));
    }
    
    public function profile()
    {
        // Get user data from session instead of Auth facade
        $userRole = session('user_role');
        $userId = session('user_id');
        $userName = session('user_name');
        
        // Create user object from session data
        $user = (object) [
            'id' => $userId,
            'nama' => $userName,
            'role' => $userRole
        ];
        
        // History peminjaman
        $peminjamanHistory = Peminjaman::where('user_id', session('user_id'))
            ->with('motor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('dashboard.profile', compact('user', 'peminjamanHistory'));
    }
    
    public function updateProfile(Request $request)
    {
        // Get user data from session instead of Auth facade
        $userRole = session('user_role');
        $userId = session('user_id');
        $userName = session('user_name');
        
        // Get actual user model for update
        if ($userRole === 'pengunjung') {
            $user = Pengunjung::find($userId);
        } else {
            $user = Admin::find($userId);
        }
        
        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan.']);
        }
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:pengunjung,phone,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.unique' => 'Nomor HP sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
        
        // Cek password lama jika ingin ganti password
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Password lama wajib diisi.']);
            }
            
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah.']);
            }
            
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        // Remove password fields that are not needed
        unset($validated['current_password']);
        unset($validated['password_confirmation']);
        
        $user->update($validated);
        
        // Update session name if changed
        if (session('user_name') !== $validated['nama']) {
            session(['user_name' => $validated['nama']]);
        }
        
        return back()->with('success', 'Profile berhasil diperbarui!');
    }
}