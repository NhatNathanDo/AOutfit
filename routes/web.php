<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Modules\Products\Controllers\ProductController;
use App\Modules\Brand\Controllers\BrandController;
use App\Modules\Category\Controllers\CategoryController;
use App\Modules\Products\Controllers\ProductAiController;
use App\Modules\Order\Controllers\OrderController;

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

// All admin routes under /admins
Route::prefix('admins')->as('admin.')->group(function () {
    // Dashboard landing: GET /admins
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'page'])->name('page');
        Route::get('/list', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('invoice');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::match(['put','patch'], '/{id}', [OrderController::class, 'update'])->name('update');
    });

    // Products
    Route::prefix('products')->as('products.')->group(function () {
        Route::get('/', [ProductController::class, 'page'])->name('page');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::get('/list', [ProductController::class, 'index'])->name('index');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::match(['put', 'patch'], '/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::delete('/{productId}/images/{imageId}', [ProductController::class, 'destroyImage'])->name('images.destroy');
        Route::post('/ai/describe', [ProductAiController::class, 'describe'])->name('ai.describe');
    });

    // Brands
    Route::prefix('brands')->as('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'page'])->name('page');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::get('/list', [BrandController::class, 'index'])->name('index');
        Route::get('/{id}', [BrandController::class, 'show'])->name('show');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::match(['put','patch'], '/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('categories')->as('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'page'])->name('page');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::get('/list', [CategoryController::class, 'index'])->name('index');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::match(['put','patch'], '/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });
});
