<?php

namespace App\Services;

use App\Models\Code;
use App\Models\User;
use App\Models\Wallet;

class WalletService
{

    public function __construct(private User $user)
    {
    }

    // Charge user wallet
    public function storeUsingCode(Code $code)
    {
        return $this->user->wallet()->create([
            'type' => Wallet::INCREMENT,
            'code_id' => $code->id,
            'amount' => $code->amount,
        ]);
    }

}
