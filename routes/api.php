<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemsController;
use App\Http\Controllers\Moderator\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'moderator'])->group(function (){
    Route::put('/orders/{orderId}', [OrderController::class, 'update']);
    Route::get('/orders/all', [OrderController::class, 'allOrders']);
    Route::delete('/products/{productId}', [ProductController::class, 'destroy']);
    Route::post('/products/{productId}', [ProductController::class, 'update']);
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
    Route::delete('/orders/{orderId}', [OrderController::class, 'cancelOrder']);
    Route::get('/orders/{orderId}', [OrderController::class, 'orderById']);
    Route::post('/orders/', [OrderController::class, 'store']);
    Route::get('/orders/', [OrderController::class, 'orderByUser']);
    Route::delete('/cart/items', [CartItemsController::class, 'destroy']);
    Route::post('/cart/items', [CartItemsController::class, 'insert']);
    Route::get('/cart/items', [CartItemsController::class, 'itemsCart']);

    Route::delete('/cart/clear', [CartController::class, 'destroy']);
    Route::get('/cart/', [CartController::class, 'cartUser']);
    Route::post('/cart/', [CartController::class, 'store']);

    Route::delete('/addresses/{addressId}', [AddressController::class, 'destroy']);
    Route::put('/addresses/{addressId}', [AddressController::class, 'update']);
    Route::get('/addresses/{addressId}', [AddressController::class, 'show']);
    Route::post('/addresses/', [AddressController:: class, 'store']);
    Route::get('/addresses/', [AddressController::class, 'addressUser']);

    Route::put('/users/me', [UserController::class, 'update']);
    Route::get('/users/me', [UserController::class, 'me']);
    Route::delete('/users/me', [UserController::class, 'destroy']); 
});

Route::get('/products/{productId}', [ProductController::class, 'show']);
Route::get('/products/', [ProductController::class, 'index']);
Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);
Route::get('/categories/', [CategoryController::class, 'index']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
