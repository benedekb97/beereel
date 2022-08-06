<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('', [AuthenticationController::class, 'login'])->name('login');
Route::post('', [AuthenticationController::class, 'authenticate'])->name('authenticate');

Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('register', [AuthenticationController::class, 'registration'])->name('registration');


Route::group(
    [
        'middleware' => 'auth',
    ],
    static function () {
        Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

        Route::get('create', [DashboardController::class, 'create'])->name('create');

        Route::post('upload', [PostController::class, 'upload'])->name('upload');
    }
);
