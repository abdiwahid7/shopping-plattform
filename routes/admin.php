<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('admin/products', ProductController::class);
    Route::resource('admin/categories', CategoryController::class);
    Route::resource('admin/orders', OrderController::class);
    Route::resource('admin/users', UserController::class);
});