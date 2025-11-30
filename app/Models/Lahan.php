<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function petani(): BelongsTo
    {
        // pakai model Petani, tabel tetap anggotatanis
        return $this->belongsTo(Petani::class, 'id_anggota', 'id_anggota');
    }

    public function tanams(): HasMany
    {
        return $this->hasMany(Tanam::class, 'id_lahan', 'id_lahan');
    }
}
