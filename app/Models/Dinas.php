<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    protected $table = 'dinas';
    protected $primaryKey = 'id_dinas';

    protected $fillable = [
        'kode_dinas',
        'nama_dinas',
        'alamat',
        'latitude',
        'longitude',
        'id_kabupaten',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten', 'id_kabupaten');
    }

    public function upts()
    {
        return $this->hasMany(Upt::class, 'id_dinas', 'id_dinas');
    }
}
