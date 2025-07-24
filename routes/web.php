<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama (home)
Route::get('/', function () {
    return view('home.dashboard');
})->name('dashboard');

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

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes (untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});