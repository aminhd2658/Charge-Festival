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

    protected $with = [
        'wallet'
    ];

    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }

    public function getBalanceAttribute()
    {
        return $this->wallet()
            ->select(DB::raw('SUM(CASE WHEN type = ' . Wallet::INCREMENT . ' THEN amount ELSE -amount END) as balance'))
            ->value('balance');
    }
}
