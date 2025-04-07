<?php

namespace App\Models;

use App\Models\COA;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisTransaksi extends Model
{
    use HasFactory;

    protected $table = 'jenis_transaksi';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['keterangan'];

    public function coa()
    {
        return $this->hasMany(COA::class, 'id_jenis_transaksi', 'id');
    }
}
