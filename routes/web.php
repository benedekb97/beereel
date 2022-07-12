<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('', [AuthenticationController::class, 'login'])->name('login');
Route::post('', [AuthenticationController::class, 'authenticate'])->name('authenticate');

Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('register', [AuthenticationController::class, 'registration'])->name('registration');

Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
