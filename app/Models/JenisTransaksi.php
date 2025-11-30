<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisTransaksi extends Model
{
    protected $table = 'jenis_transaksi'; // dari SQL dump
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'keterangan',
    ];

    public function detailJenisTransaksis(): HasMany
    {
        return $this->hasMany(DetailJenisTransaksi::class, 'id_jenis_transaksi', 'id');
    }
}
