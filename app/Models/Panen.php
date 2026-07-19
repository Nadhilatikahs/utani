<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Panen extends Model
{
    use HasFactory;

    protected $table = "panens";
    protected $primaryKey = "id_panen";

    protected $fillable = [
        'id_panen',
        'kode_panen',
        'id_tanam',
        'tgal_panen',
        'jumlah',
        'harga',
        'hasil_panen',
        'status_panen',
        'penyebab_gagal',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $status = $model->status_panen ?? 'berhasil';

            if ($status === 'gagal_total') {
                // Fully failed → quantity and revenue must be zero
                $model->jumlah      = 0;
                $model->hasil_panen = 0;
            } else {
                // Existing behaviour: hasil_panen as current implementation
                $model->hasil_panen = $model->jumlah * $model->harga;
            }

            if ($status === 'berhasil') {
                // No failure metadata for successful harvests
                $model->penyebab_gagal = null;
                $model->keterangan     = null;
            }
        });

        static::updating(function ($model) {
            $status = $model->status_panen ?? 'berhasil';

            if ($status === 'gagal_total') {
                $model->jumlah      = 0;
                $model->hasil_panen = 0;
            } else {
                $model->hasil_panen = $model->jumlah * $model->harga;
            }

            if ($status === 'berhasil') {
                $model->penyebab_gagal = null;
                $model->keterangan     = null;
            }

            \Log::info('Updating hasil_panen to ' . $model->hasil_panen);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function tanam()
    {
        return $this->belongsTo(Tanam::class, 'id_tanam', 'id_tanam');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI LAMA – DIBIARKAN
    |--------------------------------------------------------------------------
    */

    public static function getPanenDetailtanam()
    {
        $sql = "SELECT a.*,b.kode_tanam
                FROM panens a
                JOIN tanams b
                  ON (a.id_tanam=b.id_tanam)";
        $panens = DB::select($sql);

        return $panens;
    }

    public static function getKodepanen()
    {
        $sql = "SELECT IFNULL(MAX(kode_panen), 'P-000') as kode_panen
                FROM panens";
        $panens = DB::select($sql);

        foreach ($panens as $panen) {
            $p = $panen->kode_panen;
        }

        $noawal  = substr($p, -3);
        $noakhir = $noawal + 1;

        $noakhir = 'P-'.str_pad($noakhir, 3, "0", STR_PAD_LEFT);

        return $noakhir;
    }
}
