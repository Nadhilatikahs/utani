<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    protected $table = 'jenis_transaksi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'keterangan',
    ];

    public function detail()
    {
        return $this->hasMany(DetailJenisTransaksi::class, 'id_jenis_transaksi', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(ChartOfAccount::class, 'id_jenis_transaksi', 'id');
    }
}
