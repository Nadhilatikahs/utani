<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kabupaten extends Model
{
    use HasFactory;
    protected $table = "kabupatens";
    protected $primaryKey = "id_kabupaten";
    protected $fillable = [ 
        'kode_kabupaten','id_kabupaten','nama_kabupaten','latitude'
        ,'longitude','id_provinsi'];


        public static function getKabupatenDetailProvinsi()
        {
           // query kode kabupaten
        $sql = "SELECT a.*,b.nama_provinsi
                FROM kabupatens a
                JOIN provinsis b
                ON (a.id_provinsi=b.id_provinsi)";
        $kabupatens = DB::select($sql);

        return $kabupatens;
        }
        public static function getKodekabupaten()
    {
        // query kode kabupaten
        $sql = "SELECT IFNULL(MAX(kode_kabupaten), 'KB-000') as kode_kabupaten 
                FROM kabupatens";
        $kabupatens = DB::select($sql);

        // cacah hasilnya
        foreach ($kabupatens as $kab) {
            $kab = $kab->kode_kabupaten;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kab,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'KB-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
    
}
