<?php

use App\Http\Controllers\API\V1\CodesController;
use App\Http\Controllers\API\V1\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('codes')->group(function () {
        Route::post('create', [CodesController::class, 'create']);
        Route::prefix('{code:code}')->group(function () {
            Route::post('', [CodesController::class, 'register']);
            Route::put('status', [CodesController::class, 'toggleStatus']);
            Route::get('users', [CodesController::class, 'getUsersUsedCode']);
        });
    });


    Route::prefix('wallets/{user:mobile}')->group(function () {
        Route::get('balance', [UsersController::class, 'getBalance']);
        Route::get('transactions', [UsersController::class, 'getTransactionsReport']);
    });
});
