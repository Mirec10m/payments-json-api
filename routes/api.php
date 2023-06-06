<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/payments/callback/{payment}', [PaymentController::class, 'callback'])
    ->name('callback_url')
    ->middleware('signed');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // FIRST ENDPOINT
    Route::post('/payments', [PaymentController::class, 'create']);

    // SECOND ENDPOINT
    Route::get('/payments/check/{payment}', [PaymentController::class, 'check'])
        ->name('check_expired')
        ->middleware('signed');
});
