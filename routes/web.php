<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
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
        Route::get('blocked', [DashboardController::class, 'blocked'])->name('blocked');

        Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

        Route::group(
            [
                'middleware' => 'blocked',
            ],
            static function () {
                Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

                Route::get('create', [DashboardController::class, 'create'])->name('create');

                Route::post('upload', [PostController::class, 'upload'])->name('upload');

                Route::post('api/reaction', [ReactionController::class, 'reaction'])->name('api.reaction');

                Route::get('profile', [DashboardController::class, 'profile'])->name('profile');


                Route::group(
                    [
                        'middleware' => 'administrator',
                        'prefix' => 'admin',
                        'as' => 'admin.'
                    ],
                    static function () {
                        Route::get('users', [AdminController::class, 'users'])->name('users');
                        Route::get('user/{user}', [AdminController::class, 'user'])->name('user');

                        Route::get('user/{user}/block', [AdminController::class, 'block'])->name('user.block');

                        Route::get('block/{postId}', [PostController::class, 'block'])->name('block');

                        Route::get('posts', [AdminController::class, 'posts'])->name('posts');
                    }
                );
            }
        );
    }
);
