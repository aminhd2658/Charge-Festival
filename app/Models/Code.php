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

    protected $appends = ['valid'];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function getValidAttribute()
    {
        if (! Carbon::now()->betweenIncluded($this->started_at, $this->expired_at)) {
            return false;
        }

        if ($this->wallets()->count() >= $this->count) {
            return false;
        }

        return true;
    }
}
