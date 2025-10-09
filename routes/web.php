<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Products\Controllers\ProductController;

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
    Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::match(['put', 'patch'], 'products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});
