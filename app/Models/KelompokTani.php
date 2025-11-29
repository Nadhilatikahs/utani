<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokTani extends Model
{
    protected $table = 'kelompoktanis';
    protected $primaryKey = 'id_keltani';

    protected $fillable = [
        'kode_keltani',
        'nama_keltani',
        'alamat',
        'latitude',
        'longitude',
        'id_desa',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function anggotas()
    {
        return $this->hasMany(AnggotaTani::class, 'id_keltani', 'id_keltani');
    }
}
