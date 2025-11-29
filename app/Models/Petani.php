<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    protected $table = 'anggotatanis';
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'kode_anggota',
        'nama_anggota',
        'nik',
        'tempat_lahir',
        'alamat',
        'jenis_kelamin',
        'no_hp',
        'status_anggota',
        'kategori_petani',
        'latitude',
        'longitude',
        'id_keltani',
    ];

    public function kelompokTani()
    {
        return $this->belongsTo(KelompokTani::class, 'id_keltani', 'id_keltani');
    }

    public function lahans()
    {
        return $this->hasMany(Lahan::class, 'id_anggota', 'id_anggota');
    }
}
