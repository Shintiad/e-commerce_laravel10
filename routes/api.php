<?php

use App\Http\Controllers\ApiServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CartApiController;
use App\Http\Controllers\CheckoutApiController;
use App\Http\Controllers\TransactionApiController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});

Route::middleware('auth:sanctum')->get('/user/delete', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();

    return response()->json([
        'message' => 'Tokens Deleted'
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartApiController::class, 'showCart'])->name('cart');
    Route::post('/cart/{id}/add', [CartApiController::class, 'addToCart'])->name('addToCart');
    Route::put('/cart/{id}', [CartApiController::class, 'editCartItem'])->name('cart_edit');
    Route::delete('/cart/{id}', [CartApiController::class, 'deleteFromCart'])->name('cart_delete');

    Route::post('/checkout', [CheckoutApiController::class, 'processCheckout']);

    Route::get('/transaction', [TransactionApiController::class, 'show'])->name('transaction');
    Route::get('/transaction/{id}/detail', [TransactionApiController::class, 'showDetail'])->name('transaction_detail');
    Route::put('/transaction/{id}', [TransactionApiController::class, 'update']);
    Route::delete('/transaction/{id}', [TransactionApiController::class, 'destroy']);
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/register', [AuthApiController::class, 'register'])->name('register');

Route::get('/product', [ProductApiController::class, 'product']);
Route::get('/product/{id}', [ProductApiController::class, 'show']);
Route::post('/product/add', [ProductApiController::class, 'store']);
Route::put('/product/{id}', [ProductApiController::class, 'update']);
Route::delete('/product/{id}', [ProductApiController::class, 'destroy']);
Route::get('/search', [ProductApiController::class, 'search'])->name('search');

Route::get('/category', [CategoryApiController::class, 'category'])->name('category');
Route::post('/category/add', [CategoryApiController::class, 'store']);
Route::put('/category/{id}', [CategoryApiController::class, 'update']);

Route::get('/role', [UserController::class, 'role']);
