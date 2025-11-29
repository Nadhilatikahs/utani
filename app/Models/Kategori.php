<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'kode_kategori',
        'keterangan',
    ];

    public function bebans()
    {
        return $this->hasMany(Beban::class, 'id_kategori', 'id_kategori');
    }
}
