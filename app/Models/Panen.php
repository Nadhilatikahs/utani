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
        'id_panen','kode_panen','id_tanam','tgal_panen','jumlah','harga','hasil_panen'];

        protected static function boot()
        {
            parent::boot();
    
            // Menggunakan event `creating` untuk menghitung hasil_panen sebelum membuat data baru
            static::creating(function ($model) {
                $model->hasil_panen = $model->jumlah * $model->harga;
            });
    
            static::updating(function ($model) {
                $model->hasil_panen = $model->jumlah * $model->harga;
                \Log::info('Updating hasil_panen to ' . $model->hasil_panen); // Log untuk debugging
            });
        }

        

        public static function getPanenDetailtanam()
        {
           // query kode panen
        $sql = "SELECT a.*,b.kode_tanam
                FROM panens a
                JOIN tanams b
                ON (a.id_tanam=b.id_tanam)";
        $panens = DB::select($sql);

        return $panens;
        }

        
        public static function getKodepanen()
    {
        // query kode panen
        $sql = "SELECT IFNULL(MAX(kode_panen), 'P-000') as kode_panen 
                FROM panens";
        $panens = DB::select($sql);

        // cacah hasilnya
        foreach ($panens as $panen) {
            $p = $panen->kode_panen;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($p,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'P-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
