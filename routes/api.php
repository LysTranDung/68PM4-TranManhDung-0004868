<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LopHocController;
use App\Http\Controllers\Api\SinhVienController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('lop-hoc', LopHocController::class);
    Route::apiResource('sinh-vien', SinhVienController::class)->parameters(['sinh-vien' => 'sinhvien']);
});
