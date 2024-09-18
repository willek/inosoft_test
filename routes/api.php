<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\MotorController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api', 'auth:api']], function () {
    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::resource('mobil', MobilController::class)->except(['create', 'edit']);
    Route::resource('motor', MotorController::class)->except(['create', 'edit']);
});