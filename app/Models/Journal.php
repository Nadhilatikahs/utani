<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journal';
    protected $primaryKey = 'No';

    protected $fillable = [
        'akun',
        'debit',
        'kredit',
    ];

    protected $casts = [
        'debit'  => 'float',
        'kredit' => 'float',
    ];
}
