<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desas';
    protected $primaryKey = 'id_desa';

    protected $fillable = [
        'kode_desa',
        'nama_desa',
        'alamat',
        'latitude',
        'longitude',
        'id_bpp',
    ];

    public function bpp()
    {
        return $this->belongsTo(Bpp::class, 'id_bpp', 'id_bpp');
    }

    public function kelompoktanis()
    {
        return $this->hasMany(KelompokTani::class, 'id_desa', 'id_desa');
    }
}
