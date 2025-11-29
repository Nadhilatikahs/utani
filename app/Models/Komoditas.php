<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $table = 'komoditas';
    protected $primaryKey = 'id_komoditas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_komoditas',
        'nama_komoditas',
        'kategori',
        'harga_satuan',
    ];
}
