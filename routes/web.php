<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('registerPost');
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginStore'])->name('loginPost');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::get('/product/add', [ProductController::class, 'create']);
    Route::post('/product/add', [ProductController::class, 'store']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('detail');
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
    Route::post('/cart/{id}/add', [CartController::class, 'addToCart'])->name('addToCart');
    Route::put('/cart/{id}', [CartController::class, 'editCartItem'])->name('cart_edit');
    Route::delete('/cart/{id}', [CartController::class, 'deleteFromCart'])->name('cart_delete');

    Route::get('/checkout', [CartController::class, 'redirectToCheckout'])->name('checkout');
    Route::post('/process_checkout', [CheckoutController::class, 'processCheckout'])->name('process_checkout');
    
    Route::get('/category', [CategoryController::class, 'category'])->name('category');
    Route::get('/category/add', [CategoryController::class, 'create']);
    Route::post('/category/add', [CategoryController::class, 'store']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('product_category');
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

    Route::get('/transaction', [TransactionController::class, 'show'])->name('transaction');
    Route::get('/transaction/{id}/detail', [TransactionController::class, 'showDetail'])->name('transaction_detail');
    Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit']);
    Route::put('/transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);
});