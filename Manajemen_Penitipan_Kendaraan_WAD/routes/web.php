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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // Dashboard routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    Route::middleware(['auth:penjaga'])->group(function () {
        Route::get('/penjaga/dashboard', function () {
            return view('penjaga.dashboard');
        })->name('penjaga.dashboard');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    // Pelanggan routes
    Route::middleware(['auth'])->group(function () {
        Route::resource('kendaraans', KendaraanController::class);
        Route::resource('transaksis', TransaksiController::class);
        Route::get('/profile', [PelangganController::class, 'index'])->name('profile');
    });

    // Penjaga routes
    Route::middleware(['auth:penjaga'])->group(function () {
        Route::resource('layanan', LayananController::class)->except(['index', 'show']);
        Route::get('/penjaga/profile', [PenjagaProfileController::class, 'edit'])->name('penjaga.profile');
        Route::put('/penjaga/profile', [PenjagaProfileController::class, 'update'])->name('penjaga.profile.update');
    });

    // Admin routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::resource('pelanggans', PelangganController::class)->except(['create', 'store']);
        Route::resource('penjagas', PenjagaController::class)->except(['create', 'store']);
    });

    // Public routes
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');

    // Authentication routes
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    });

    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    // Authentication routes for Penjaga
    Route::middleware(['guest:penjaga'])->group(function () {
        Route::get('/penjaga/login', [PenjagaController::class, 'showLoginForm'])->name('penjaga.login');
        Route::get('/penjaga/register', [PenjagaController::class, 'create'])->name('penjaga.register');
    });
    Route::post('/penjaga/login', [PenjagaController::class, 'login'])->name('penjaga.login.submit');
    Route::post('/penjaga/register', [PenjagaController::class, 'store'])->name('penjaga.register.submit');
    Route::post('/penjaga/logout', [PenjagaController::class, 'logout'])->name('penjaga.logout');

    // Authentication routes for Admin (login only)
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    });
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
