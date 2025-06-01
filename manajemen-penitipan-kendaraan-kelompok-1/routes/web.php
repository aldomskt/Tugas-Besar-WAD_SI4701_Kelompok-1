<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PenjagaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenjagaProfileController;
use App\Http\Controllers\AdminPelangganController;
use Illuminate\Support\Facades\Auth;

// Route untuk daftar catatan pembayaran admin (PALING ATAS)
Route::get('admin/transaksis/catatan', [TransaksiController::class, 'catatanIndex'])
    ->middleware('auth:admin')
    ->name('admin.transaksis.catatan.index');

Route::get('/', fn() => view('welcome'));

// ================== PELANGGAN ==================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::resource('kendaraans', KendaraanController::class);
    Route::resource('transaksis', TransaksiController::class)->only(['index', 'show']);
    Route::get('/profile', [PelangganController::class, 'index'])->name('profile');
    Route::put('/profile', [PelangganController::class, 'update'])->name('profile.update');
    Route::resource('transaksis', TransaksiController::class)->only(['index', 'show', 'destroy']);
});

// ================== PENJAGA ==================
Route::middleware(['auth:penjaga'])->group(function () {
    Route::get('/penjaga/dashboard', [DashboardController::class, 'index'])->name('penjaga.dashboard');
    Route::resource('layanan', LayananController::class);
    Route::get('/penjaga/profile', [PenjagaProfileController::class, 'edit'])->name('penjaga.profile');
    Route::put('/penjaga/profile', [PenjagaProfileController::class, 'update'])->name('penjaga.profile.update');
    Route::get('/penjaga/riwayat-transaksi', [TransaksiController::class, 'riwayatPenjaga'])->name('penjaga.riwayatTransaksi');
    Route::put('/transaksis/{transaksi}', [TransaksiController::class, 'update'])->name('transaksis.update');
});

// ================== ADMIN ==================
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('pelanggans', AdminPelangganController::class)->except(['create', 'store']);
        Route::resource('penjagas', PenjagaController::class)->except(['create', 'store']);
        Route::resource('transaksis', TransaksiController::class)->only(['index', 'show', 'destroy', 'update', 'edit']);
        
        // Payment Notes Routes
        Route::get('transaksis/catatan', [TransaksiController::class, 'catatanIndex'])->name('transaksis.catatan.index');
        Route::get('transaksis/{transaksi}/catatan/create', [TransaksiController::class, 'createCatatanPembayaran'])->name('transaksis.catatan.create');
        Route::post('transaksis/{transaksi}/catatan', [TransaksiController::class, 'storeCatatanPembayaran'])->name('transaksis.catatan.store');
    });
});

Route::fallback(fn() => redirect('/login'));

Route::get('/debug-admin', function() {
    return Auth::guard('admin')->check() ? 'Anda login sebagai admin' : 'Bukan admin';
});

// ================== PUBLIK ==================
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');
Route::get('/layanan/{id}/pesan', [TransaksiController::class, 'formTambahKendaraan'])->name('layanan.pesan');
Route::get('/transaksi/store-after-kendaraan', [TransaksiController::class, 'storeAfterKendaraan'])->name('transaksi.storeAfterKendaraan');
Route::get('/transaksi/pembayaran', [TransaksiController::class, 'showPembayaran'])->name('transaksi.pembayaran');
Route::post('/transaksi/pembayaran', [TransaksiController::class, 'prosesPembayaran'])->name('transaksi.prosesPembayaran');

// ================== AUTH PELANGGAN ==================
Route::get('/logout-all', function() {
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();
    Auth::guard('penjaga')->logout();
    session()->flush();
    session()->regenerate();
    return redirect('/login');
})->name('logout.all');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
});
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ================== AUTH PENJAGA ==================
Route::middleware(['guest:penjaga'])->group(function () {
    Route::get('/penjaga/login', [PenjagaController::class, 'showLoginForm'])->name('penjaga.login');
    Route::get('/penjaga/register', [PenjagaController::class, 'create'])->name('penjaga.register');
});
Route::post('/penjaga/login', [PenjagaController::class, 'login'])->name('penjaga.login.submit');
Route::post('/penjaga/register', [PenjagaController::class, 'store'])->name('penjaga.register.submit');
Route::post('/penjaga/logout', [PenjagaController::class, 'logout'])->name('penjaga.logout');

// ================== AUTH ADMIN ==================
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
});
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

