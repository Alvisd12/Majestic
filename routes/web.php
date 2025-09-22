<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestimoniController;

// Halaman utama (home)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/harga-sewa', [HomeController::class, 'hargaSewa'])->name('harga_sewa');

Route::get('/layanan', function () {
    return view('home.layanan');
})->name('layanan');

Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');

Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Testimoni routes
Route::post('/testimoni', [\App\Http\Controllers\TestimoniController::class, 'store'])->name('testimoni.store');
Route::post('/testimoni/public', [\App\Http\Controllers\TestimoniController::class, 'storePublic'])->name('testimoni.public.store');
Route::get('/testimoni/approved', [\App\Http\Controllers\TestimoniController::class, 'getApproved'])->name('testimoni.approved');
Route::get('/testimoni/check-eligibility', [\App\Http\Controllers\TestimoniController::class, 'checkEligibility'])->name('testimoni.check-eligibility');

// Motor detail page
Route::get('/motor/{id}', [HomeController::class, 'motorDetail'])->name('motor.detail');

// Session expired route (accessible without login)
Route::get('/session-expired', function () {
    return view('auth.session-expired');
})->name('session.expired');

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

// Update late rentals route (temporary for data migration)
Route::get('/update-late-rentals', [AdminController::class, 'updateLateRentals']);

// Authenticated routes (untuk user dan admin yang sudah login)
Route::middleware(['check.login', 'prevent.back'])->group(function () {
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
    // Print receipt route
    Route::get('/peminjaman/{id}/print', [PeminjamanController::class, 'print'])->name('peminjaman.print');

    // Motor booking route (from motor detail page)
    Route::post('/motor/{id}/book', [PeminjamanController::class, 'bookMotor'])->name('motor.book');
    Route::get('/my-bookings', [PeminjamanController::class, 'userBookings'])->name('user.bookings');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('user.profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/profile/upload-photo', [AuthController::class, 'uploadProfilePhoto'])->name('user.profile.upload-photo');
    Route::delete('/profile/delete-photo', [AuthController::class, 'deleteProfilePhoto'])->name('user.profile.delete-photo');
    
    // Admin routes dengan prefix 'admin'
    Route::prefix('admin')->middleware('auto.update.status')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/harga-sewa', [AdminController::class, 'hargaSewa'])->name('admin.harga_sewa');
        
        // Motor Management Routes
        Route::get('/motor', [AdminController::class, 'motorIndex'])->name('admin.motor.index');
        Route::get('/motor/create', [AdminController::class, 'motorCreate'])->name('admin.motor.create');
        
        // Testimoni routes
        Route::get('/testimoni', [AdminController::class, 'testimoniIndex'])->name('admin.testimoni');
        Route::get('/testimoni/{id}', [AdminController::class, 'testimoniShow'])->name('admin.testimoni.show');
        Route::post('/testimoni/{id}/approve', [AdminController::class, 'testimoniApprove'])->name('admin.testimoni.approve');
        Route::post('/testimoni/{id}/reject', [AdminController::class, 'testimoniReject'])->name('admin.testimoni.reject');
        Route::delete('/testimoni/{id}', [AdminController::class, 'testimoniDestroy'])->name('admin.testimoni.destroy');
        
        Route::put('/peminjaman/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.peminjaman.status');
        Route::delete('/peminjaman/{id}', [AdminController::class, 'destroy'])->name('admin.peminjaman.destroy');
        Route::get('/peminjaman/{id}', [AdminController::class, 'show'])->name('admin.peminjaman.show');
        
        // Motor Management Routes
        Route::post('/motor', [AdminController::class, 'motorStore'])->name('admin.motor.store');
        Route::get('/motor/{id}/edit', [AdminController::class, 'motorEdit'])->name('admin.motor.edit');
        Route::put('/motor/{id}', [AdminController::class, 'motorUpdate'])->name('admin.motor.update');
        Route::delete('/motor/{id}', [AdminController::class, 'motorDestroy'])->name('admin.motor.destroy');
        
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

        // Blog routes
        Route::get('/blog', [AdminController::class, 'blogIndex'])->name('admin.blog');
        Route::get('/blog/create', [AdminController::class, 'blogCreate'])->name('admin.blog.create');
        Route::post('/blog', [AdminController::class, 'blogStore'])->name('admin.blog.store');
        Route::get('/blog/{id}/edit', [AdminController::class, 'blogEdit'])->name('admin.blog.edit');
        Route::put('/blog/{id}', [AdminController::class, 'blogUpdate'])->name('admin.blog.update');
        Route::delete('/blog/{id}', [AdminController::class, 'blogDestroy'])->name('admin.blog.destroy');

        // Admin Account Management routes
        Route::get('/admin-accounts', [AdminAccountController::class, 'index'])->name('admin.admin_accounts');
        Route::get('/admin-accounts/create', [AdminAccountController::class, 'create'])->name('admin.admin_accounts.create');
        Route::post('/admin-accounts', [AdminAccountController::class, 'store'])->name('admin.admin_accounts.store');
        Route::get('/admin-accounts/{id}/edit', [AdminAccountController::class, 'edit'])->name('admin.admin_accounts.edit');
        Route::put('/admin-accounts/{id}', [AdminAccountController::class, 'update'])->name('admin.admin_accounts.update');
        Route::delete('/admin-accounts/{id}', [AdminAccountController::class, 'destroy'])->name('admin.admin_accounts.destroy');
        
        // Admin Profile Management routes
        Route::get('/profile', [\App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile.show');
        Route::put('/profile', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/profile/upload-photo', [\App\Http\Controllers\AdminProfileController::class, 'uploadPhoto'])->name('admin.profile.upload-photo');
        Route::delete('/profile/delete-photo', [\App\Http\Controllers\AdminProfileController::class, 'deletePhoto'])->name('admin.profile.delete-photo');
        
        // General Settings routes
        Route::get('/general', [\App\Http\Controllers\Admin\GeneralController::class, 'index'])->name('admin.general.index');
        Route::get('/general/edit', [\App\Http\Controllers\Admin\GeneralController::class, 'edit'])->name('admin.general.edit');
        Route::put('/general', [\App\Http\Controllers\Admin\GeneralController::class, 'update'])->name('admin.general.update');
        
        Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
        Route::get('/statistics', [AdminController::class, 'getStatistics'])->name('admin.statistics');
    });
});

// Testimoni routes (outside middleware groups)
Route::get('/testimoni/create/{booking_id}', [TestimoniController::class, 'create'])->name('testimoni.create');
Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');