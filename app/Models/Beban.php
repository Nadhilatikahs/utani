<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beban extends Model
{
    protected $table = 'bebans';
    protected $primaryKey = 'id_beban';

    protected $fillable = [
        'kode_beban',
        'nama_beban',
        'kategori',
        'id_kategori',
    ];

    public function kategoriRef()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function bebanTanams()
    {
        return $this->hasMany(BebanTanam::class, 'id_beban', 'id_beban');
    }
}
