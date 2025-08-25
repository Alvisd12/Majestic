<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;


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

Route::get('/motor-detail/{id}', function ($id) {
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    $viewPath = 'home.motor-detail.detail' . $id;
    

    if (!view()->exists($viewPath)) {
        abort(404);
    }

    return view($viewPath);
});




// Guest routes (untuk user yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Admin register (bisa diakses tanpa login)
    Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'adminRegister']);
});

// Authenticated routes (untuk user dan admin yang sudah login)
Route::middleware('auth')->group(function () {
    // User dashboard
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Peminjaman routes (untuk user biasa dan admin)
    Route::resource('peminjaman', PeminjamanController::class);

    // Admin routes dengan prefix 'admin'
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::put('/peminjaman/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.peminjaman.status');
        Route::delete('/peminjaman/{id}', [AdminController::class, 'destroy'])->name('admin.peminjaman.destroy');
        Route::get('/peminjaman/{id}', [AdminController::class, 'show'])->name('admin.peminjaman.show');
        Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
        Route::get('/statistics', [AdminController::class, 'getStatistics'])->name('admin.statistics');
    });
});
