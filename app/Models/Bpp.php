<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bpp extends Model
{
    protected $table = 'bpps';
    protected $primaryKey = 'id_bpp';

    protected $fillable = [
        'kode_bpp',
        'nama_bpp',
        'alamat',
        'latitude',
        'longitude',
        'id_upt',
    ];

    public function upt()
    {
        return $this->belongsTo(Upt::class, 'id_upt', 'id_upt');
    }

    public function desas()
    {
        return $this->hasMany(Desa::class, 'id_bpp', 'id_bpp');
    }
}
