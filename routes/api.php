<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['checkAuth'])->group(function () {
Route::get('/product/list', [ProductController::class, 'list']);
Route::get('/product/{id}', [ProductController::class, 'details']);
Route::get('/logout', [AuthController::class, 'logout']);


    
});
