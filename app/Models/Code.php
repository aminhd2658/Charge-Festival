<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    const INACTIVE = 0;
    const ACTIVE = 1;

    protected $fillable = [
        'code',
        'count',
        'amount',
        'status'
    ];

    protected $appends = ['isValid'];

    protected $casts = [
        'status' => 'integer',
        'amount' => 'integer',
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }


    public function getStatusInHumanAttribute()
    {
        return match ($this->status) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }


    // Check code is valid or not - if returns true, code is usable
    public function getIsValidAttribute()
    {
        return $this->status == self::ACTIVE && $this->wallets()->count() < $this->count;
    }
}
