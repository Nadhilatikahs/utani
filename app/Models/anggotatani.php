<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class anggotatani extends Model
{
    protected $table = 'anggotatanis';
    protected $primaryKey = 'id_anggota';
    public $incrementing = true;
    protected $keyType = 'int';

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
}
