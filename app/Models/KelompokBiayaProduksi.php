<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokBiayaProduksi extends Model
{
    use HasFactory;

    protected $table = 'kelompok_biaya_produksis';
    protected $primaryKey = 'id_kelompok_biaya_produksi';

    protected $fillable = [
        'id_kelompok_biaya_produksi',
        'kode_kelompok',
        'nama_kelompok',
    ];
}
