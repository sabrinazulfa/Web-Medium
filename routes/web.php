<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ContentController as UserContentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{id}', [HomeController::class, 'show'])->name('article');
Route::post('/comment/{id}', [HomeController::class, 'comment'])->name('comment');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['role' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('user', AdminUserController::class);
        Route::resource('content', AdminContentController::class);
    });

    Route::group(['role' => 'user','prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::resource('content', UserContentController::class);
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});