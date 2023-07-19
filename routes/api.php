<?php

use App\Http\Controllers\API\V1\WalletController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/wallet/code', [WalletController::class, 'registerCode']);
});
