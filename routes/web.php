<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('admin.home');
});

// Product CRUD routes under admin prefix
Route::prefix('admin')->group(function () {
    // Orders
    Route::get('orders', [OrderController::class, 'page'])->name('admin.orders.page');
    Route::get('orders/list', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::match(['put','patch'], 'orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    // Page
    Route::get('products', [ProductController::class, 'page'])->name('admin.products.page');
    // Create page
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    // Edit page
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    // Data (JSON)
    Route::get('products/list', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::match(['put', 'patch'], 'products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::delete('products/{productId}/images/{imageId}', [ProductController::class, 'destroyImage'])->name('admin.products.images.destroy');
    Route::post('products/ai/describe', [ProductAiController::class, 'describe'])->name('admin.products.ai.describe');

    // Brands
    Route::get('brands', [BrandController::class, 'page'])->name('admin.brands.page');
    Route::get('brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
    Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('admin.brands.edit');
    Route::get('brands/list', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::get('brands/{id}', [BrandController::class, 'show'])->name('admin.brands.show');
    Route::post('brands', [BrandController::class, 'store'])->name('admin.brands.store');
    Route::match(['put','patch'], 'brands/{id}', [BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('brands/{id}', [BrandController::class, 'destroy'])->name('admin.brands.destroy');

    // Categories
    Route::get('categories', [CategoryController::class, 'page'])->name('admin.categories.page');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::get('categories/list', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('admin.categories.show');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::match(['put','patch'], 'categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});
