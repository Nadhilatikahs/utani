<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_type', 'transaction_date', 'amount', 'description'];

    public function journalEntries()
    {
        return $this->hasMany(GeneralJournal::class);
    }
}