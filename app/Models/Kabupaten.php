<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupatens';
    protected $primaryKey = 'id_kabupaten';

    protected $fillable = [
        'kode_kabupaten',
        'nama_kabupaten',
        'latitude',
        'longitude',
        'id_provinsi',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id_provinsi');
    }

    public function dinas()
    {
        return $this->hasMany(Dinas::class, 'id_kabupaten', 'id_kabupaten');
    }
}
