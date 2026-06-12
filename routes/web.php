<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Vendor\AuthController as VendorRegisterController;
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

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('/vendors/pending', [AdminVendorController::class, 'pendingList'])->name('vendors.pending');
    Route::post('/vendors/{id}/approve', [AdminVendorController::class, 'approve'])->name('vendors.approve');
    Route::post('/vendors/{id}/reject', [AdminVendorController::class, 'reject'])->name('vendors.reject');
});

Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'role:vendor', 'vendor.status'])->group(function () {
    Route::view('/dashboard', 'vendor.dashboard')->name('dashboard');
});