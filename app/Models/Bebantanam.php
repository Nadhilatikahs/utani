<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bebantanam extends Model
{
    use HasFactory;

    protected $table = "bebantanam";
    protected $primaryKey = "id_bebantanam";

    protected $fillable = [
        'id_bebantanam',
        'kode_bebantanam',
        'id_tanam',
        'id_beban',
        'satuan',
        'jumlah',
        'harga',
        'total',
    ];

    protected static function boot()
    {
        parent::boot();

        // Hitung total sebelum insert
        static::creating(function ($model) {
            $model->total = $model->jumlah * $model->harga;
        });

        // Hitung total sebelum update
        static::updating(function ($model) {
            $model->total = $model->jumlah * $model->harga;
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

    public function beban()
    {
        return $this->belongsTo(Beban::class, 'id_beban', 'id_beban');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI LAMA
    |--------------------------------------------------------------------------
    */

    public static function getBebantanamDetailtanam()
    {
        $sql = "SELECT a.*,b.kode_tanam
                FROM bebantanam a
                JOIN tanams b
                  ON (a.id_tanam=b.id_tanam)";
        $bebantanam = DB::select($sql);

        return $bebantanam;
    }

    public static function getBebantanamDetailbeban()
    {
        $sql = "SELECT a.*,b.nama_beban
                FROM bebantanam a
                JOIN bebans b
                  ON (a.id_beban=b.id_beban)";
        $bebantanams = DB::select($sql);

        return $bebantanams;
    }

    public static function getKodebebantanam()
    {
        $sql = "SELECT IFNULL(MAX(kode_bebantanam), 'BT-000') as kode_bebantanam
                FROM bebantanam";
        $bebantanam = DB::select($sql);

        foreach ($bebantanam as $beban) {
            $bt = $beban->kode_bebantanam;
        }

        $noawal  = substr($bt, -3);
        $noakhir = $noawal + 1;

        $noakhir = 'BT-'.str_pad($noakhir, 3, "0", STR_PAD_LEFT);

        return $noakhir;
    }
}
