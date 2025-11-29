<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    protected $table = 'panens';
    protected $primaryKey = 'id_panen';

    protected $fillable = [
        'kode_panen',
        'id_tanam',
        'tgal_panen',
        'jumlah',
        'harga',
        'hasil_panen',
    ];

    protected $casts = [
        'tgal_panen' => 'date',
        'jumlah'     => 'float',
        'harga'      => 'float',
    ];

    public function tanam()
    {
        return $this->belongsTo(Tanam::class, 'id_tanam', 'id_tanam');
    }

    public function getTotalAttribute(): float
    {
        if (!is_null($this->hasil_panen)) {
            return (float) $this->hasil_panen;
        }

        return (float) ($this->jumlah * $this->harga);
    }
}
