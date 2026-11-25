<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SinhVienController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [LoginController::class, 'create'])->name('login');
    Route::post('/dang-nhap', [LoginController::class, 'store'])->middleware('throttle:5,1');
});
Route::post('/dang-xuat', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('lophoc.index'))->name('home');
    Route::resource('lophoc', LopHocController::class);
    Route::resource('sinhvien', SinhVienController::class);
    Route::get('/tai-khoan', [UserController::class, 'profile'])->name('profile.edit');
    Route::put('/tai-khoan', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::middleware('admin')->group(function () {
        Route::resource('menu', MenuController::class)->except('show');
        Route::resource('users', UserController::class)->except('show');
    });
});

