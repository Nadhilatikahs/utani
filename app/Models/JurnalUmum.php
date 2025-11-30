<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    protected $table = 'jurnal';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'keterangan',
        'kas_masuk',
        'kas_keluar',
        'saldo',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'kas_masuk'  => 'decimal:2',
        'kas_keluar' => 'decimal:2',
        'saldo'      => 'decimal:2',
    ];
}
