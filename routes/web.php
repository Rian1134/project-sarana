<?php

use App\Http\Controllers\Admin\DataController as AdminDataController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Admin\PeriodeLaporanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\PengajuanController as UserPengajuanController;
use App\Http\Controllers\User\DataController as UserDataController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RencanaPembangunanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::view('/panduan', 'landing.panduan')->name('panduan');

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::resource('sarana', AdminDataController::class)->parameters(['sarana' => 'profileSekolah']);
            Route::resource('user', AdminUserController::class);
            Route::post('/sarana/export-excel', [AdminDataController::class, 'export_excel'])->name('data.export');
            Route::get('/periode', [PeriodeLaporanController::class, 'edit'])->name('admin.periode.edit');
            Route::put('/periode', [PeriodeLaporanController::class, 'update'])->name('admin.periode.update');
            Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');
            Route::get('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
            Route::post('/pengajuan/{pengajuan}/approve', [AdminPengajuanController::class, 'approve'])->name('pengajuan.approve');
            Route::post('/pengajuan/{pengajuan}/reject', [AdminPengajuanController::class, 'reject'])->name('pengajuan.reject');
            Route::get('/rencana-pembangunan/', [AdminPengajuanController::class, 'rencanaPembangunanIndex'])->name('rencana.index');

        });
    });

    // User routes (untuk user biasa)
    Route::middleware('role:user')->group(function () {
        Route::prefix('/user')->name('user.')->group(function () {
            Route::resource('data', UserDataController::class)->only(['create', 'edit', 'update', 'store', 'destroy'])->parameters(['data' => 'profileSekolah']);

            // Profile routes
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
            Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

            Route::resource('pengajuan', UserPengajuanController::class);
            Route::resource('rencana-pembangunan', RencanaPembangunanController::class)->parameters(['rencana-pembangunan' => 'pengajuan']);
        });
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

});

Route::view('/demo', 'demo');