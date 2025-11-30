<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function anggotas(): HasMany
    {
        // lagi-lagi pakai model Petani
        return $this->hasMany(Petani::class, 'id_keltani', 'id_keltani');
    }
}
