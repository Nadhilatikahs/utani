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
        'id_bebantanam','kode_bebantanam','id_tanam','id_beban','satuan','jumlah','harga','total'];

        protected static function boot()
        {
            parent::boot();
    
            // Menggunakan event `creating` untuk menghitung total sebelum membuat data baru
            static::creating(function ($model) {
                $model->total = $model->jumlah * $model->harga;
            });
    
            // Menggunakan event `updating` untuk menghitung total sebelum memperbarui data
            static::updating(function ($model) {
                $model->total = $model->jumlah * $model->harga;
            });
        }

        

        

        public static function getBebantanamDetailtanam()
        {
           // query kode beban tanam
        $sql = "SELECT a.*,b.kode_tanam
                FROM bebantanam a
                JOIN tanams b
                ON (a.id_tanam=b.id_tanam)";
        $bebantanam = DB::select($sql);

        return $bebantanam;
        }

        public static function getBebantanamDetailbeban()
        {
           // query kode beban tanam
        $sql = "SELECT a.*,b.nama_beban
                FROM bebantanam a
                JOIN bebans b
                ON (a.id_beban=b.id_beban)";
        $bebantanams = DB::select($sql);

        return $bebantanams;
        }

        public static function getKodebebantanam()
    {
        // query kode bebantanam
        $sql = "SELECT IFNULL(MAX(kode_bebantanam), 'BT-000') as kode_bebantanam 
                FROM bebantanam";
        $bebantanam = DB::select($sql);

        // cacah hasilnya
        foreach ($bebantanam as $beban) {
            $bt = $beban->kode_bebantanam;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($bt,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'BT-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
