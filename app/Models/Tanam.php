<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'tgl_tanam'      => 'date',
        'tgl_panen'      => 'date',
        'volume_panen'   => 'float',
        'beban_variabel' => 'float',
        'beban_fix'      => 'float',
        'keuntungan'     => 'float',
    ];

    // supaya bisa dipanggil sebagai $tanam->total_pendapatan dll
    protected $appends = [
        'total_pendapatan',
        'total_biaya_variabel',
        'total_biaya_tetap',
        'total_biaya',
        'keuntungan_bersih',
    ];

    public function lahan(): BelongsTo
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }

    public function komoditas(): BelongsTo
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id_komoditas');
    }

    public function bebanTanams(): HasMany
    {
        return $this->hasMany(BebanTanam::class, 'id_tanam', 'id_tanam');
    }

    public function panens(): HasMany
    {
        return $this->hasMany(Panen::class, 'id_tanam', 'id_tanam');
    }

    // 🔢 Pendapatan = Σ(jumlah * harga) dari tabel panens
    public function getTotalPendapatanAttribute(): float
    {
        return (float) $this->panens->sum(fn (Panen $p) => $p->jumlah * $p->harga);
    }

    // 🔢 Biaya Variabel = Σ total dari beban_tanams (BBB + BTKL + BOP)
    public function getTotalBiayaVariabelAttribute(): float
    {
        return (float) $this->bebanTanams->sum('total');
    }

    // 🔢 Biaya Tetap = kolom beban_fix
    public function getTotalBiayaTetapAttribute(): float
    {
        return (float) ($this->beban_fix ?? 0);
    }

    // 🔢 Total Biaya Produksi
    public function getTotalBiayaAttribute(): float
    {
        return $this->total_biaya_variabel + $this->total_biaya_tetap;
    }

    // 🔢 Keuntungan Bersih (kalau kolom keuntungan kosong, hitung otomatis)
    public function getKeuntunganBersihAttribute(): float
    {
        if (! is_null($this->keuntungan)) {
            return (float) $this->keuntungan;
        }

        return $this->total_pendapatan - $this->total_biaya;
    }
}
