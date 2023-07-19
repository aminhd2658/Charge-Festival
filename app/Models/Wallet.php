<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    // Types
    const INCREMENT = 0;
    const DECREMENT = 1;

    protected $fillable = [
        'type',
        'amount',
        'code_id'
    ];

    protected $casts = [
        'amount' => 'integer',
        'type' => 'integer'
    ];

    public function code()
    {
        return $this->belongsTo(Code::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeInHumanAttribute()
    {
        return match ($this->type) {
            self::INCREMENT => 'Increment wallet balance',
            self::DECREMENT => 'Decrement wallet balance',
        };
    }
}
