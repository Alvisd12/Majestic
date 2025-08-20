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
            'email' => 'required|email|max:255|unique:pengunjung,email',
            'password' => 'required|string|min:6',
            'no_handphone' => 'required|string|max:20|unique:pengunjung,no_handphone',
            'alamat' => 'required|string|max:500',
            'foto_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'no_handphone.required' => 'Nomor HP wajib diisi.',
            'no_handphone.max' => 'Nomor HP maksimal 20 karakter.',
            'no_handphone.unique' => 'Nomor HP sudah digunakan.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'foto_ktp.image' => 'File harus berupa gambar.',
            'foto_ktp.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
            'foto_ktp.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Handle file upload
        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $file = $request->file('foto_ktp');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fotoKtpPath = $file->storeAs('ktp', $filename, 'public');
        }

        $pengunjung = Pengunjung::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_handphone' => $validated['no_handphone'],
            'alamat' => $validated['alamat'],
            'foto_ktp' => $fotoKtpPath,
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
            
            return redirect()->route('home')
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

    /**
     * Show user profile
     */
    public function showProfile()
    {
        self::requireAuth();
        
        $user = self::getCurrentUser();
        
        return view('profile.show', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        self::requireAuth();
        
        $user = self::getCurrentUser();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pengunjung,email,' . $user->id,
            'no_handphone' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'no_handphone.required' => 'Nomor handphone wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Update data
        $updateData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_handphone' => $validated['no_handphone'],
            'alamat' => $validated['alamat'],
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        if (session('user_role') === 'admin') {
            \App\Models\Admin::where('id', $user->id)->update($updateData);
        } else {
            \App\Models\Pengunjung::where('id', $user->id)->update($updateData);
        }

        // Update session data
        session(['user_name' => $validated['nama']]);

        return redirect()->route('user.profile')->with('success', 'Profile berhasil diperbarui!');
    }
}