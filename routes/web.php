<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class , 'home'])->name('home');
Route::get('/category/{category}', [ProductController::class , 'category'])->name('category');
Route::get('/product/{slug}', [ProductController::class , 'show'])->name('product.detail');
Route::post('/order/{product_id}', [OrderController::class , 'store'])->name('order.store');

Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class , 'dashboard'])->name('dashboard');

    // Product Management
    Route::get('/products', [AdminController::class , 'products'])->name('products');
    Route::get('/products/create', [AdminController::class , 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class , 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class , 'editProduct'])->name('products.edit');
    Route::post('/products/{id}/update', [AdminController::class , 'updateProduct'])->name('products.update');
    Route::post('/products/{id}/restock', [AdminController::class , 'restockProduct'])->name('products.restock');
    Route::post('/stock-history/{id}/delete', [AdminController::class , 'deleteStockHistory'])->name('stock-history.delete');
    Route::post('/products/{id}/delete', [AdminController::class , 'deleteProduct'])->name('products.delete');

    Route::get('/orders', [AdminController::class , 'orders'])->name('orders');
    Route::post('/orders/{id}/verify', [AdminController::class , 'verifyOrder'])->name('orders.verify');
    Route::post('/orders/{id}/cancel', [AdminController::class , 'cancelOrder'])->name('orders.cancel');
});
