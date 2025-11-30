<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function kelompokTani(): BelongsTo
    {
        return $this->belongsTo(KelompokTani::class, 'id_keltani', 'id_keltani');
    }

    public function lahans(): HasMany
    {
        return $this->hasMany(Lahan::class, 'id_anggota', 'id_anggota');
    }
}
