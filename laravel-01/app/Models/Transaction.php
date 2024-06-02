<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'iban',
        'bank',
        'amount',
        'currency',
        'currency_rate',
        'result',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
