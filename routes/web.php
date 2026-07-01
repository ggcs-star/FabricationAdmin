<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Vendor\AuthController as VendorRegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('vendor')->name('vendor.')->middleware('guest')->group(function () {
    Route::get('/register', [VendorRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [VendorRegisterController::class, 'register'])->name('register.submit');
});

// Admin panel — login skipped for now (direct access)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('vendors', AdminVendorController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);

    Route::get('/vendors/pending/list', [AdminVendorController::class, 'pendingList'])->name('vendors.pending');
    Route::post('/vendors/{id}/approve', [AdminVendorController::class, 'approve'])->name('vendors.approve');
    Route::post('/vendors/{id}/reject', [AdminVendorController::class, 'reject'])->name('vendors.reject');
});

Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'role:vendor', 'vendor.status'])->group(function () {
    Route::view('/dashboard', 'vendor.dashboard')->name('dashboard');
});
