<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $table = 'komoditas';
    protected $primaryKey = 'id_komoditas';

    protected $fillable = [
        'kode_komoditas',
        'nama_komoditas',
        'kategori',
        'harga_satuan',
    ];

    public function tanams()
    {
        return $this->hasMany(Tanam::class, 'id_komoditas', 'id_komoditas');
    }
}
