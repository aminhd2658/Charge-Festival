<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function store(array $data)
    {
        return User::firstOrCreate([
            'mobile' => $data['mobile']
        ]);
    }
}
