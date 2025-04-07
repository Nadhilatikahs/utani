<?php

namespace App\Models;

use App\Models\JenisTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class COA extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['kode_akun', 'id_jenis_transaksi', 'nama_akun', 'header', 'posisi_dr_cr', 'saldo_awal'];

    protected $table = 'chart_of_accounts';

    public function jenisTransaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'id_jenis_transaksi', 'id');
    }
}
