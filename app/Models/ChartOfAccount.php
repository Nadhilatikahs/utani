<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChartOfAccount extends Model
{
    protected $table = 'chart_of_accounts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kode_akun',
        'id_jenis_transaksi',
        'nama_akun',
        'header',
        'posisi_dr_cr',
        'saldo_awal',
    ];

    public function jenisTransaksi(): BelongsTo
    {
        return $this->belongsTo(JenisTransaksi::class, 'id_jenis_transaksi', 'id');
    }
}
