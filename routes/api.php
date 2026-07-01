<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\VendorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {

    Route::post('register',[AuthController::class, 'register']);

    Route::post('login',[AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

    Route::get('me',[AuthController::class, 'me']);

    Route::post('logout',[AuthController::class, 'logout']);

        });

});

Route::prefix('customer')->group(function () {
    Route::get('vendors', [CatalogController::class, 'vendors']);
    Route::get('categories', [CatalogController::class, 'categories']);
    Route::get('services', [CatalogController::class, 'services']);
    Route::get('products', [CatalogController::class, 'products']);
});

Route::middleware('auth:api')->prefix('admin')->group(function () {
    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('products', ProductController::class);
});
