<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Moderator\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'moderator'])->group(function (){
    Route::delete('/products/{productId}', [ProductController::class, ' destroy']);
    Route::put('/products/{productId}', [ProductController::class, 'update']);
    Route::post('/products/', [ProductController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function (){
    Route::delete('/discounts/{discountId}', [DiscountController::class, 'destroy']);
    Route::put('/discounts/{discountId}', [DiscountController::class, 'update']);
    Route::get('/discounts/{discountId}', [DiscountController::class, 'show']);
    Route::get('/discounts/', [DiscountController::class, 'index']);
    Route::post('/discounts/', [DiscountController::class, 'store']);
    Route::delete('/coupons/{couponId}', [CouponController::class, 'destroy']);
    Route::put('/coupons/{couponId}', [CouponController::class, 'update']);
    Route::get('/coupons/{couponId}', [CouponController::class, 'show']);
    Route::get('/coupons/', [CouponController::class, 'index']);
    Route::post('/coupons/', [CouponController::class, 'store']);
    Route::delete('/categories/{categoryId}', [CategoryController::class, 'destroy']);
    Route::put('/categories/{categoryId}', [CategoryController::class, 'update']);
    Route::post('/categories/', [CategoryController::class, 'store']);

    Route::post('user/create-moderator', [AdminUserController::class, 'store']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/addresses/{addressId}', [AddressController::class, 'destroy']);
    Route::put('/addresses/{addressId}', [AddressController::class, 'update']);
    Route::get('/addresses/{addressId}', [AddressController::class, 'show']);
    Route::post('/addresses/', [AddressController:: class, 'store']);
    Route::get('/addresses/', [AddressController::class, 'index']);

    Route::put('/users/me', [UserController::class, 'update']);
    Route::get('/users/me', [UserController::class, 'index']);
    Route::delete('/users/me', [UserController::class, 'destroy']); 
});

Route::get('/products/{productId}', [ProductController::class, 'show']);
Route::get('/products/', [ProductController::class, 'index']);
Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);
Route::get('/categories/', [CategoryController::class, 'index']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
