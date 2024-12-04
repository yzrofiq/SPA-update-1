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
use App\Http\Controllers\UserBayarController;
use App\Http\Controllers\UserTagihanController;
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
    // Dashboard route
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    // Admin-specific routes (admin role check)
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


Route::resource('tagihans', TagihanController::class);
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
        Route::get('tagihans/create', [TagihanController::class, 'create'])->name('tagihans.create');
        Route::post('tagihans', [TagihanController::class, 'store'])->name('tagihans.store');
        

    });

    // User-specific routes (user role check)
    Route::middleware(['role:user'])->prefix('user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        // User Tagihan (Invoices)
        Route::get('/tagihans', [UserTagihanController::class, 'index'])->name('user.tagihans.index');
        Route::get('/tagihans/{id}', [UserTagihanController::class, 'show'])->name('user.tagihans.show');

        // User Bayar (Payment creation)
        Route::get('/pembayarans', [UserBayarController::class, 'index'])->name('user.pembayarans.index');
        Route::get('/bayar/{id}', [UserBayarController::class, 'create'])->name('user.bayar.create');
        Route::get('/bayar/{tagihanId}', [UserBayarController::class, 'createPayment'])->name('user.payment.create');
        Route::post('/bayar/{tagihanId}', [UserBayarController::class, 'storePayment'])->name('user.payment.store');
        Route::post('/user/bayar/verify/{tagihanId}', [UserBayarController::class, 'verifyPayment']);
        Route::post('/tagihans/{id}/update-status', [UserBayarController::class, 'updateStatus'])
    ->name('user.tagihan.update-status')
    ->middleware('auth');
    });
});

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Rute notifikasi verifikasi
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Rute untuk verifikasi email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Rute untuk mengirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi baru telah dikirim ke email Anda.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::post('/user/tagihan/{id}/update-status', [UserBayarController::class, 'updateStatus'])
    ->name('user.tagihan.update-status');
