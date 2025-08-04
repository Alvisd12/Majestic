<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // =========================
    // === PENGUNJUNG AUTH ====
    // =========================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengunjung,username',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20|unique:pengunjung,phone',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone.required' => 'Nomor HP wajib diisi.',
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
            Auth::login($admin);
            $request->session()->regenerate();
            session([
                'user_role' => 'admin',
                'user_id' => $admin->id,
                'user_name' => $admin->nama
            ]);
            
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Login admin berhasil!');
        }

        // Cek pengunjung jika bukan admin
        $pengunjung = Pengunjung::where('username', $credentials['username'])->first();
        if ($pengunjung && Hash::check($credentials['password'], $pengunjung->password)) {
            Auth::login($pengunjung);
            $request->session()->regenerate();
            session([
                'user_role' => 'pengunjung',
                'user_id' => $pengunjung->id,
                'user_name' => $pengunjung->nama
            ]);
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $userRole = session('user_role');
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $message = $userRole === 'admin' ? 'Logout admin berhasil!' : 'Logout berhasil!';
        
        return redirect()->route('home')->with('success', $message);
    }

    // ====================
    // ==== ADMIN AUTH ====
    // ====================

    public function showAdminRegister()
    {
        return view('auth.admin-register');
    }

    public function adminRegister(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20|unique:admin,phone',
            'email' => 'nullable|email|unique:admin,email',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username admin sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.unique' => 'Nomor HP admin sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email admin sudah digunakan.',
        ]);

        $admin = Admin::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi admin berhasil! Silakan login.');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    // =======================
    // ==== HELPER METHODS ====
    // =======================

    /**
     * Check if current user is admin
     */
    public static function isAdmin()
    {
        return session('user_role') === 'admin';
    }

    /**
     * Check if current user is pengunjung
     */
    public static function isPengunjung()
    {
        return session('user_role') === 'pengunjung';
    }

    /**
     * Get current user data
     */
    public static function getCurrentUser()
    {
        $userRole = session('user_role');
        $userId = session('user_id');

        if (!$userRole || !$userId) {
            return null;
        }

        if ($userRole === 'admin') {
            return Admin::find($userId);
        } elseif ($userRole === 'pengunjung') {
            return Pengunjung::find($userId);
        }

        return null;
    }

    /**
     * Middleware alternative for checking admin access
     */
    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Middleware alternative for checking authenticated user
     */
    public static function requireAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
}