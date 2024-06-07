<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CurrencyAccount;

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

    public function currencyAccount()
    {
        return $this->belongsTo(CurrencyAccount::class);
    }
}
