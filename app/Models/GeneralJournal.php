<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralJournal extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_date', 'account_name', 'debit', 'credit', 'description'];

    public function cashTransaction()
    {
        return $this->belongsTo(CashTransaction::class);
    }
}