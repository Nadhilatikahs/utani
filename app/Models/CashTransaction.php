<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $table = 'cash_transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_type',
        'transaction_date',
        'amount',
        'description',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount'           => 'float',
    ];
}
