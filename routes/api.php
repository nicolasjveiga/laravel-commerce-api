<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth:sanctum', 'role:ADMIN'])->group(function () {
    Route::post('/register/mod', [AuthController::class, 'registerMod'])->name('register.mod');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/coupons', [CouponController::class, 'index'])->name('coupon.index');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupons/{coupon}', [CouponController::class, 'show'])->name('coupon.show');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupon.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupon.destroy');

    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
    Route::post('/discounts', [DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/discounts/{discount}', [DiscountController::class, 'show'])->name('discounts.show');
    Route::put('/discounts/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
    
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware(['auth:sanctum', 'role:MODERATOR'])->group(function (){
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/my-addresses', [AddressController::class, 'myAddresses'])->name('addresses.my');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});