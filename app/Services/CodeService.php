<?php

namespace App\Services;

use App\Models\Code;
use App\Models\User;

class CodeService
{

    public function __construct(private Code $code)
    {
    }


    // Returns true if the user used the code
    public function used(User $user)
    {
        return (bool)$user->wallet()->where('code_id', $this->code->id)->first();
    }
}
