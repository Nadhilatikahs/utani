<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    protected $table = 'lahans';
    protected $primaryKey = 'id_lahan';

    protected $fillable = [
        'kode_lahan',
        'id_anggota',
        'luas',
        'jml_petak',
    ];

    public function petani()
    {
        return $this->belongsTo(AnggotaTani::class, 'id_anggota', 'id_anggota');
    }

    public function tanams()
    {
        return $this->hasMany(Tanam::class, 'id_lahan', 'id_lahan');
    }
}
