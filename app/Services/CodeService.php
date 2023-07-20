<?php

namespace App\Services;

use App\Models\Code;
use App\Models\User;

class CodeService
{

    public function __construct(private ?Code $code = null)
    {
    }


    // Create new code
    public function create(array $data)
    {
        return Code::create([
            'code' => $data['code'],
            'count' => $data['count'],
            'amount' => $data['amount'],
            'status' => Code::INACTIVE
        ]);
    }


    // Returns true if the user used the code
    public function used(User $user)
    {
        return (bool)$user->wallet()->where('code_id', $this->code->id)->first();
    }


    // Change status of code
    public function changeStatus($nextStatus)
    {
        return $this->code->update([
            'status' => $nextStatus
        ]);
    }
}
