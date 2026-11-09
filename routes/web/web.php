<?php

use App\Http\Controllers\Web\V1\Categories\CategoriesController;
use App\Http\Controllers\Web\V1\Dashboard\DashboardController;
use App\Http\Controllers\Web\V1\Users\UserManagementController;
use Illuminate\Support\Facades\Route;

// ! Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ! User Management module
Route::resource('users', UserManagementController::class);
Route::post('user/status/{id}', [UserManagementController::class, 'status'])->name('users.status');

// ! Category Management module
Route::resource('category', CategoriesController::class);
Route::post('category/status/{id}', [CategoriesController::class, 'status'])->name('category.status');
