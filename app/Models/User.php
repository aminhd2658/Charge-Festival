<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile'
    ];

    protected $appends = [
        'balance'
    ];


    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }


    // Calculating the current balance of the user wallet
    // The sum of the amount column is rows where the type is 0 minus rows where the type is 1
    public function getBalanceAttribute()
    {
        return (integer)$this->wallet()
            ->select(DB::raw('SUM(CASE WHEN type = ' . Wallet::INCREMENT . ' THEN amount ELSE -amount END) as balance'))
            ->value('balance');
    }
}
