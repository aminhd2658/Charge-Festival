<?php

use App\Http\Controllers\API\V1\CodesController;
use App\Http\Controllers\API\V1\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('code', [CodesController::class, 'register']);
    Route::get('{code:code}/users', [CodesController::class, 'getUsersUsedCode']);
    Route::prefix('wallets/{user:mobile}')->group(function () {
        Route::get('balance', [UsersController::class, 'getBalance']);
        Route::get('transactions', [UsersController::class, 'getTransactionsReport']);
    });
});
