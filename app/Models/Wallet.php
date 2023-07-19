<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallet';
    const INCREMENT = 0;
    const DECREMENT = 1;

    protected $fillable = [
        'type',
        'amount',
        'code_id'
    ];

    public function code()
    {
        return $this->belongsTo(Code::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
