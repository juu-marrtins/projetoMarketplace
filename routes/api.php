<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'admin'])->group(function (){
    Route::post('user/create-moderator', [AdminUserController::class, 'store']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('/users/me', [UserController::class, 'update']);
    Route::get('/users/me', [UserController::class, 'index']);
    Route::delete('/users/me', [UserController::class, 'destroy']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
