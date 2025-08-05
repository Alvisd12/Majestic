<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\WisataController;

// Halaman utama (home)
Route::get('/', function () {
    return view('home.dashboard');
})->name('home');

Route::get('/harga-sewa', function () {
    return view('home.harga_sewa');
})->name('harga_sewa');

Route::get('/layanan', function () {
    return view('home.layanan');
})->name('layanan');

Route::get('/galeri', function () {
    return view('home.galeri');
})->name('galeri');

Route::get('/kontak', function () {
    return view('home.kontak');
})->name('kontak');

// Wisata routes
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.show');

// Guest routes (untuk user yang belum login)
Route::middleware('check.guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Admin register (bisa diakses tanpa login)
    Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'adminRegister']);
});

// Authenticated routes (untuk user dan admin yang sudah login)
Route::middleware('check.login')->group(function () {
    // User dashboard
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
    
    // Auth dashboard route
    Route::get('/auth/dashboard', function () {
        // Update status otomatis untuk admin
        if (session('user_role') === 'admin') {
            \App\Services\PeminjamanStatusService::updateStatuses();
        }
        $userRole = session('user_role');
        $userId = session('user_id');
        
        if ($userRole === 'admin') {
            // Redirect to admin dashboard with data
            return app(AdminController::class)->dashboard(request());
        } else {
            // For pengunjung, prepare data and use the pengunjung dashboard view
            $user = (object) [
                'id' => $userId,
                'nama' => session('user_name'),
                'role' => $userRole
            ];
            
            // Get user's peminjaman data
            $recentPeminjaman = \App\Models\Peminjaman::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Get available motors
            $availableMotor = \App\Models\Motor::where('status', 'Tersedia')
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->get();
            if ($availableMotor->isEmpty()) {
                $availableMotor = collect(); // Return an empty collection if no motors are available
            }
            
            // Statistics
            $stats = [
                'total_peminjaman' => \App\Models\Peminjaman::where('user_id', $userId)->count(),
                'peminjaman_aktif' => \App\Models\Peminjaman::where('user_id', $userId)
                    ->whereIn('status', ['Confirmed', 'Disewa'])
                    ->count(),
                'peminjaman_selesai' => \App\Models\Peminjaman::where('user_id', $userId)
                    ->where('status', 'Selesai')
                    ->count(),
                'motor_tersedia' => \App\Models\Motor::where('status', 'Tersedia')->count(),
            ];
            
            return view('auth.dashboardPengunjung', compact('user', 'stats', 'recentPeminjaman', 'availableMotor'));
        }
    })->name('auth.dashboard');
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Peminjaman routes (untuk user biasa dan admin)
    Route::resource('peminjaman', PeminjamanController::class);
    
    // Admin routes dengan prefix 'admin'
    Route::prefix('admin')->middleware('auto.update.status')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/harga-sewa', [AdminController::class, 'hargaSewa'])->name('admin.harga_sewa');
        
        // Motor Management Routes
        Route::get('/motor', [AdminController::class, 'motorIndex'])->name('admin.motor.index');
        Route::get('/motor/create', [AdminController::class, 'motorCreate'])->name('admin.motor.create');
        Route::post('/motor', [AdminController::class, 'motorStore'])->name('admin.motor.store');
        Route::get('/motor/{id}/edit', [AdminController::class, 'motorEdit'])->name('admin.motor.edit');
        Route::put('/motor/{id}', [AdminController::class, 'motorUpdate'])->name('admin.motor.update');
        Route::delete('/motor/{id}', [AdminController::class, 'motorDestroy'])->name('admin.motor.destroy');
        
        Route::put('/peminjaman/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.peminjaman.status');
        Route::delete('/peminjaman/{id}', [AdminController::class, 'destroy'])->name('admin.peminjaman.destroy');
        Route::get('/peminjaman/{id}', [AdminController::class, 'show'])->name('admin.peminjaman.show');
        
        // Confirmation routes
        Route::get('/konfirmasi', [AdminController::class, 'konfirmasi'])->name('admin.konfirmasi');
        Route::post('/peminjaman/{id}/approve', [AdminController::class, 'approve'])->name('admin.peminjaman.approve');
        Route::post('/peminjaman/{id}/reject', [AdminController::class, 'reject'])->name('admin.peminjaman.reject');
        
        // Dipinjam routes
        Route::get('/dipinjam', [AdminController::class, 'dipinjam'])->name('admin.dipinjam');
        Route::post('/peminjaman/{id}/start-rental', [AdminController::class, 'startRental'])->name('admin.peminjaman.start-rental');
        Route::post('/peminjaman/{id}/finish-rental', [AdminController::class, 'finishRental'])->name('admin.peminjaman.finish-rental');
        
        // Dikembalikan routes
        Route::get('/dikembalikan', [AdminController::class, 'dikembalikan'])->name('admin.dikembalikan');
        
        // Galeri routes
        Route::get('/galeri', [AdminController::class, 'galeriIndex'])->name('admin.galeri');
        Route::get('/galeri/create', [AdminController::class, 'galeriCreate'])->name('admin.galeri.create');
        Route::post('/galeri', [AdminController::class, 'galeriStore'])->name('admin.galeri.store');
        Route::get('/galeri/{id}/edit', [AdminController::class, 'galeriEdit'])->name('admin.galeri.edit');
        Route::put('/galeri/{id}', [AdminController::class, 'galeriUpdate'])->name('admin.galeri.update');
        Route::delete('/galeri/{id}', [AdminController::class, 'galeriDestroy'])->name('admin.galeri.destroy');
        
        Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
        Route::get('/statistics', [AdminController::class, 'getStatistics'])->name('admin.statistics');
    });
});