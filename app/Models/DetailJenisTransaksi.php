<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailJenisTransaksi extends Model
{
    protected $table = 'detail_jenis_transaksi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_jenis_transaksi',
        'keterangan',
    ];

    public function jenisTransaksi(): BelongsTo
    {
        return $this->belongsTo(JenisTransaksi::class, 'id_jenis_transaksi', 'id');
    }
}
