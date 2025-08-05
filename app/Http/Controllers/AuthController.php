<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // =========================
    // === REGISTER PENGUNJUNG ===
    // =========================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:pengunjung,username',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20|unique:pengunjung,phone',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'phone.unique' => 'Nomor HP sudah digunakan.',
        ]);

        $pengunjung = Pengunjung::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // =========================
    // === LOGIN ===
    // =========================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cek admin terlebih dahulu
        $admin = Admin::where('username', $credentials['username'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Set session tanpa menggunakan Auth facade
            $request->session()->regenerate();
            
            session([
                'user_role' => 'admin',
                'user_id' => $admin->id,
                'user_name' => $admin->nama,
                'is_logged_in' => true
            ]);
            
            return redirect()->route('auth.dashboard')
                ->with('success', 'Login admin berhasil!');
        }

        // Cek pengunjung jika bukan admin
        $pengunjung = Pengunjung::where('username', $credentials['username'])->first();
        if ($pengunjung && Hash::check($credentials['password'], $pengunjung->password)) {
            // Set session tanpa menggunakan Auth facade
            $request->session()->regenerate();
            
            session([
                'user_role' => 'pengunjung',
                'user_id' => $pengunjung->id,
                'user_name' => $pengunjung->nama,
                'is_logged_in' => true
            ]);
            
            return redirect()->route('auth.dashboard')
                ->with('success', 'Login berhasil! Selamat datang ' . $pengunjung->nama);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // =========================
    // === LOGOUT ===
    // =========================

    public function logout(Request $request)
    {
        $userRole = session('user_role');
        
        // Clear session tanpa menggunakan Auth facade
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $message = $userRole === 'admin' ? 'Logout admin berhasil!' : 'Logout berhasil!';
        
        return redirect()->route('home')->with('success', $message);
    }

    // =========================
    // === ADMIN REGISTER (Optional) ===
    // =========================

    public function showAdminRegister()
    {
        // Hanya bisa diakses jika sudah ada admin yang login
        if (!session('user_role') === 'admin') {
            abort(403, 'Akses ditolak.');
        }
        
        return view('auth.admin-register');
    }

    public function adminRegister(Request $request)
    {
        // Hanya bisa diakses jika sudah ada admin yang login
        if (!session('user_role') === 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:admin,username',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20|unique:admin,phone',
            'email' => 'nullable|email|unique:admin,email',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username admin sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.unique' => 'Nomor HP admin sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email admin sudah digunakan.',
        ]);

        Admin::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin baru berhasil didaftarkan!');
    }

    // =========================
    // === STATIC METHODS FOR OTHER CONTROLLERS ===
    // =========================

    public static function requireAuth()
    {
        if (!session('is_logged_in')) {
            abort(401, 'Anda harus login terlebih dahulu.');
        }
    }

    public static function requireAdmin()
    {
        if (session('user_role') !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }

    public static function isAdmin()
    {
        return session('user_role') === 'admin';
    }

    public static function getCurrentUser()
    {
        $userRole = session('user_role');
        $userId = session('user_id');
        $userName = session('user_name');
        
        if ($userRole === 'admin') {
            return Admin::find($userId);
        } else {
            return Pengunjung::find($userId);
        }
    }
}