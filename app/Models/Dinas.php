<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dinas extends Model
{
    use HasFactory;
   
    protected $table = "dinas";
    protected $primaryKey = "id_dinas";
    protected $fillable = [ 
        'kode_dinas', 'id_dinas','nama_dinas','alamat','latitude','longitude','id_kabupaten'];



        public static function getDinasDetailKabupaten()
        {
           // query kode dinas
        $sql = "SELECT a.*,b.nama_kabupaten
                FROM dinas a
                JOIN kabupatens b
                ON (a.id_kabupaten=b.id_kabupaten)";
        $dinas = DB::select($sql);

        return $dinas;
        }

        public static function getKodedinas()
    {
        // query kode dinas
        $sql = "SELECT IFNULL(MAX(kode_dinas), 'DN-000') as kode_dinas
                FROM dinas";
        $dinas = DB::select($sql);

        // cacah hasilnya
        foreach ($dinas as $dns) {
            $dn = $dns->kode_dinas;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($dn,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'DN-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
