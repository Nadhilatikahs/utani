<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tanam extends Model
{
    use HasFactory;

    protected $table = 'tanams';
    protected $primaryKey = 'id_tanam';

    protected $fillable = [
        'id_tanam',
        'kode_tanam',
        'id_lahan',
        'id_komoditas',
        'tgl_tanam',
        'tgl_panen',
        'volume_tanam',
        'keuntungan',
        'beban_variabel',
        'beban_fix',
    ];

    protected $casts = [
        'tgl_tanam' => 'date',
        'tgl_panen' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id_komoditas');
    }

    public function panens()
    {
        return $this->hasMany(Panen::class, 'id_tanam', 'id_tanam');
    }

    public function bebantanam()
    {
        return $this->hasMany(Bebantanam::class, 'id_tanam', 'id_tanam');
    }

    public function bebanTanams()
    {
        return $this->hasMany(Bebantanam::class, 'id_tanam', 'id_tanam');
    }

    protected static function boot()
    {
        parent::boot();

        /*
        static::creating(function ($model) {
            $model->keuntungan = $model->volume_tanam - ($model->beban_variabel + $model->beban_fix);
        });

        static::updating(function ($model) {
            $model->keuntungan = $model->volume_tanam - ($model->beban_variabel + $model->beban_fix);
        });
        */
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor perhitungan (dipakai dashboard & laporan)
    |--------------------------------------------------------------------------
    */

    public function getTotalPendapatanAttribute(): float
    {
        $total = $this->panens->sum(function (Panen $p) {
            if (! is_null($p->hasil_panen)) {
                return (float) $p->hasil_panen;
            }

            return (float) ($p->jumlah ?? 0) * (float) ($p->harga ?? 0);
        });

        return (float) $total;
    }

    /**
     * Helper: cek apakah untuk tanam ini sudah ada minimal 1 transaksi bebantanam
     * yang kategorinya memiliki keterangan "Beban Variabel" atau "Beban Fix".
     */
    protected function hasKeteranganVarOrFix(): bool
    {
        $count = DB::table('bebantanam as bt')
            ->join('bebans as b', 'b.id_beban', '=', 'bt.id_beban')
            ->join('kategori as k', 'k.id_kategori', '=', 'b.id_kategori')
            ->where('bt.id_tanam', $this->id_tanam)
            ->where(function ($q) {
                $q->where('k.keterangan', 'like', 'Beban Variabel%')
                  ->orWhere('k.keterangan', 'like', 'Beban Fix%');
            })
            ->count();

        return $count > 0;
    }

    protected function sumBebanTanamByKeteranganPrefix(string $prefix): float
    {
        $total = DB::table('bebantanam as bt')
            ->join('bebans as b', 'b.id_beban', '=', 'bt.id_beban')
            ->join('kategori as k', 'k.id_kategori', '=', 'b.id_kategori')
            ->where('bt.id_tanam', $this->id_tanam)
            ->where('k.keterangan', 'like', $prefix . '%')
            ->selectRaw('COALESCE(SUM(COALESCE(bt.total, (COALESCE(bt.jumlah,0) * COALESCE(bt.harga,0)))), 0) as total')
            ->value('total');

        return (float) ($total ?? 0);
    }

    // Total biaya variabel:
    // 1) jika sudah ada klasifikasi kategori (Beban Variabel/Fix) → hitung dari bebantanam by keterangan
    // 2) jika belum → fallback logic lama
    public function getTotalBiayaVariabelAttribute(): float
    {
        if ($this->hasKeteranganVarOrFix()) {
            return $this->sumBebanTanamByKeteranganPrefix('Beban Variabel');
        }

        // fallback lama
        if (! is_null($this->beban_variabel)) {
            return (float) $this->beban_variabel;
        }

        return (float) $this->bebantanam->sum(function (Bebantanam $bt) {
            if (! is_null($bt->total)) {
                return (float) $bt->total;
            }

            return (float) ($bt->jumlah ?? 0) * (float) ($bt->harga ?? 0);
        });
    }

    // Total biaya tetap:
    // 1) jika sudah ada klasifikasi kategori → hitung dari bebantanam by keterangan
    // 2) jika belum → fallback lama (kolom beban_fix)
    public function getTotalBiayaTetapAttribute(): float
    {
        if ($this->hasKeteranganVarOrFix()) {
            return $this->sumBebanTanamByKeteranganPrefix('Beban Fix');
        }

        return (float) ($this->beban_fix ?? 0);
    }

    public function getTotalBiayaAttribute(): float
    {
        return $this->total_biaya_variabel + $this->total_biaya_tetap;
    }

    public function getKeuntunganAktualAttribute(): float
    {
        if (! is_null($this->keuntungan)) {
            return (float) $this->keuntungan;
        }

        return $this->total_pendapatan - $this->total_biaya;
    }

    public function getKeuntunganBersihAttribute(): float
    {
        return $this->keuntungan_aktual;
    }

    /*
    |--------------------------------------------------------------------------
    | Fungsi lama berbasis raw SQL (dibiarkan, kalau masih dipakai)
    |--------------------------------------------------------------------------
    */

    public static function getTanamDetailtotal()
    {
        $sql = "SELECT a.beban_variabel,b.total
                FROM tanams a
                JOIN bebantanam b
                  ON (a.beban_variabel=b.total)";

        return DB::select($sql);
    }

    public static function getTanamDetaillahan()
    {
        $sql = "SELECT a.*,b.kode_lahan
                FROM tanams a
                JOIN lahans b
                  ON (a.id_lahan=b.id_lahan)";

        return DB::select($sql);
    }

    public static function getTanamDetailkomoditas()
    {
        $sql = "SELECT a.*,b.nama_komoditas
                FROM tanams a
                JOIN komoditas b
                  ON (a.id_komoditas=b.id_komoditas)";

        return DB::select($sql);
    }

    public static function getKodetanam()
    {
        $sql = "SELECT IFNULL(MAX(kode_tanam), 'TM-000') as kode_tanam
                FROM tanams";

        $tanams = DB::select($sql);

        foreach ($tanams as $tanam) {
            $tm = $tanam->kode_tanam;
        }

        $noawal  = substr($tm, -3);
        $noakhir = $noawal + 1;

        return 'TM-'.str_pad($noakhir, 3, '0', STR_PAD_LEFT);
    }
}
