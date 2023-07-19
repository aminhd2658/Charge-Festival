<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\User;

class UsersController extends Controller
{
    public function getBalance(User $user)
    {
        return response()->json([
            'data' => [
                'balance' => $user->balance,
                'balance_in_human' => number_format($user->balance)
            ]
        ]);
    }

    public function getTransactionsReport(User $user)
    {
        return response()->json([
            'data' => TransactionResource::collection($user->wallet()->orderByDesc('created_at')->get())
        ]);
    }
}
