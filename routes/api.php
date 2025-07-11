<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'admin'])->group(function (){
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

Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);
Route::get('/categories/', [CategoryController::class, 'index']); 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
