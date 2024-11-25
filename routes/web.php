<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PaymentController;

// Landing page route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes for guests
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Default Laravel auth routes
Auth::routes();

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard redirection
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    // Admin-specific routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Manage Pelanggan (Customers)
        Route::resource('pelanggans', PelangganController::class)->names([
            'index' => 'pelanggans.index',
            'create' => 'pelanggans.create',
            'store' => 'pelanggans.store',
            'show' => 'pelanggans.show',
            'edit' => 'pelanggans.edit',
            'update' => 'pelanggans.update',
            'destroy' => 'pelanggans.destroy',
        ]);
        Route::get('/pelanggans/export', [PelangganController::class, 'exportCSV'])->name('pelanggans.export');
        Route::get('/pelanggans/filter', [PelangganController::class, 'filterByAddress'])->name('pelanggans.filter');
        Route::get('/pelanggans/sort/{order}', [PelangganController::class, 'sortByName'])->name('pelanggans.sort');

        // Manage Tagihan (Invoices)
        Route::resource('tagihans', TagihanController::class)->except(['show'])->names([
            'index' => 'tagihans.index',
            'create' => 'tagihans.create',
            'store' => 'tagihans.store',
            'edit' => 'tagihans.edit',
            'update' => 'tagihans.update',
            'destroy' => 'tagihans.destroy',
        ]);
        Route::put('tagihans/{id}/status', [TagihanController::class, 'updateStatus'])->name('tagihans.updateStatus');

        // Manage Pembayaran (Payments)
        Route::resource('pembayarans', PembayaranController::class)->names([
            'index' => 'pembayarans.index',
            'create' => 'pembayarans.create',
            'store' => 'pembayarans.store',
            'show' => 'pembayarans.show',
            'edit' => 'pembayarans.edit',
            'update' => 'pembayarans.update',
            'destroy' => 'pembayarans.destroy',
        ]);
    });

    // User-specific routes
    Route::middleware(['role:user'])->prefix('user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        // View Tagihan (Invoices)
        Route::resource('tagihans', TagihanController::class)->only(['index', 'show'])->names([
            'index' => 'user.tagihans.index',
            'show' => 'user.tagihans.show',
        ]);

        // View Pembayaran (Payments)
        Route::resource('pembayarans', PembayaranController::class)->only(['index', 'show'])->names([
            'index' => 'user.pembayarans.index',
            'show' => 'user.pembayarans.show',
        ]);
    });

    // Shared routes
    Route::get('/bayar/{tagihan}', [PaymentController::class, 'create'])->name('user.payment.create');
    Route::post('/bayar/{tagihan}', [PaymentController::class, 'store'])->name('user.payment.store');
    Route::get('/pembayaran/{tagihan}', [PembayaranController::class, 'create'])->name('user.pembayaran.create');
    Route::post('/pembayaran/{tagihan}', [PembayaranController::class, 'store'])->name('user.pembayaran.store');
});
// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('pelanggans', PelangganController::class);
    Route::resource('tagihans', TagihanController::class);
    Route::resource('pembayarans', PembayaranController::class);

    // Export data pelanggan ke CSV
    Route::get('/pelanggans/export', [PelangganController::class, 'exportCSV'])->name('pelanggans.export');

    // Filter berdasarkan alamat
    Route::get('/pelanggans/filter', [PelangganController::class, 'filterByAddress'])->name('pelanggans.filter');

    // Pengurutan berdasarkan nama
    Route::get('/pelanggans/sort/{order}', [PelangganController::class, 'sortByName'])->name('pelanggans.sort');
});

// Dashboard route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
