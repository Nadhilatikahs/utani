<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upt extends Model
{
    protected $table = 'upts';
    protected $primaryKey = 'id_upt';

    protected $fillable = [
        'kode_upt',
        'nama_upt',
        'alamat',
        'latitude',
        'longitude',
        'id_dinas',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }

    public function bpps()
    {
        return $this->hasMany(Bpp::class, 'id_upt', 'id_upt');
    }
}
