<?php

use App\Http\Controllers\Admin\DataController as AdminDataController;
use App\Http\Controllers\Admin\PeriodeLaporanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DataController as UserDataController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index'])->name('home.index');

Route::middleware('auth')->group(function () {
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::resource('sarana', AdminDataController::class);
            Route::post('/sarana/export-excel', [AdminDataController::class, 'export_excel'])->name('data.export');
            Route::resource('user', AdminUserController::class);
            Route::get('/periode', [PeriodeLaporanController::class, 'edit'])->name('admin.periode.edit');
            Route::put('/periode', [PeriodeLaporanController::class, 'update'])->name('admin.periode.update');
        });
    });

    // User routes (untuk user biasa)
    Route::middleware('role:user')->group(function () {
        Route::prefix('/user')->name('user.')->group(function () {
            Route::resource('data', UserDataController::class)->parameters(['data' => 'sarana']);
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::get('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        });
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
});

// Route::view('/demo', 'demo');
