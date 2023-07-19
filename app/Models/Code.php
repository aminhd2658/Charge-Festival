<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'count',
        'amount',
        'started_at',
        'expired_at',
    ];

    protected $appends = ['isValid'];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    // Check code is valid or not - if returns true, code is usable
    public function getIsValidAttribute()
    {
        if (!Carbon::now()->betweenIncluded($this->started_at, $this->expired_at)) {
            return false;
        }

        if ($this->wallets()->count() >= $this->count) {
            return false;
        }

        return true;
    }
}
