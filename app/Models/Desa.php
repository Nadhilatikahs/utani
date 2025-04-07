<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Desa extends Model
{
    use HasFactory;
    
    protected $table = "desas";
    protected $primaryKey = "id_desa";
    protected $fillable = [ 
        'id_desa','kode_desa','nama_desa','alamat','latitude','longitude','id_bpp'];



        public static function getDesaDetailBpp()
        {
           // query kode unit pelaksana teknis
        $sql = "SELECT a.*,b.nama_bpp
                FROM desas a
                JOIN bpps b
                ON (a.id_bpp=b.id_bpp)";
        $desas = DB::select($sql);

        return $desas;
        }

        public static function getKodedesa()
    {
        // query kode desa
        $sql = "SELECT IFNULL(MAX(kode_desa), 'DES-000') as kode_desa
                FROM desas";
        $desas = DB::select($sql);

        // cacah hasilnya
        foreach ($desas as $des) {
            $des = $des->kode_desa;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($des,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'DES-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
