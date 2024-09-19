<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api', 'auth:api']], function () {
    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    // CRUD: mobil + motor
    Route::resource('mobil', MobilController::class)->except(['create', 'edit']);
    Route::resource('motor', MotorController::class)->except(['create', 'edit']);

    // Stock, Jual, Beli kendaraan
    Route::group(['prefix' => 'kendaraan'], function () {
        Route::get('/{kendaraan_id?}', [KendaraanController::class, 'index']);
        Route::post('/beli', [KendaraanController::class, 'beli']);
        Route::post('/jual', [KendaraanController::class, 'jual']);
    });

    // Report Sales + Purchase
    Route::group(['prefix' => 'report'], function () {
        Route::get('sales/{kendaraan_id?}', [ReportController::class, 'sales']);
        Route::get('purchase/{kendaraan_id?}', [ReportController::class, 'purchase']);
    });
});
