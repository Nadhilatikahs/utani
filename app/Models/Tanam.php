<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanam extends Model
{
    protected $table = 'tanams';
    protected $primaryKey = 'id_tanam';

    protected $fillable = [
        'kode_tanam',
        'id_lahan',
        'id_komoditas',
        'tgl_tanam',
        'tgl_panen',
        'volume_panen',
        'beban_variabel',
        'beban_fix',
        'keuntungan',
    ];

    protected $casts = [
        'tgl_tanam'       => 'date',
        'tgl_panen'       => 'date',
        'volume_panen'    => 'float',
        'beban_variabel'  => 'float',
        'beban_fix'       => 'float',
        'keuntungan'      => 'float',
    ];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id_komoditas');
    }

    public function bebanTanams()
    {
        return $this->hasMany(BebanTanam::class, 'id_tanam', 'id_tanam');
    }

    public function panens()
    {
        return $this->hasMany(Panen::class, 'id_tanam', 'id_tanam');
    }

    public function getTotalPendapatanAttribute(): float
    {
        return (float) $this->panens->sum(fn (Panen $p) => $p->jumlah * $p->harga);
    }

    public function getTotalBiayaVariabelAttribute(): float
    {
        return (float) $this->bebanTanams->sum('total');
    }

    public function getTotalBiayaTetapAttribute(): float
    {
        return (float) ($this->beban_fix ?? 0);
    }

    public function getTotalBiayaAttribute(): float
    {
        return $this->total_biaya_variabel + $this->total_biaya_tetap;
    }

    public function getKeuntunganBersihAttribute(): float
    {
        if (!is_null($this->keuntungan)) {
            return (float) $this->keuntungan;
        }

        return $this->total_pendapatan - $this->total_biaya;
    }
}
