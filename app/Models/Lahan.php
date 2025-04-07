<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lahan extends Model
{
    use HasFactory;
    protected $table = "lahans";
    protected $primaryKey = "id_lahan";
    protected $fillable = [ 
        'id_lahan','kode_lahan','id_anggota','luas','jml_petak'];


        public static function getLahanDetailanggota()
        {
           // query kode unit pelaksana teknis
        $sql = "SELECT a.*,b.nama_anggota as nama_anggota
                FROM lahans a
                JOIN anggotatanis b
                ON (a.id_anggota=b.id_anggota)";
        $lahans = DB::select($sql);

        return $lahans;
        }

        public static function getKodelahan()
    {
        // query kode lahan
        $sql = "SELECT IFNULL(MAX(kode_lahan), 'LH-000') as kode_lahan
                FROM lahans";
        $lahans = DB::select($sql);

        // cacah hasilnya
        foreach ($lahans as $lahan) {
            $lh = $lahan->kode_lahan;
        }
        // Mengambil substring tiga digit akhir dari string AT-000
        $noawal = substr($lh,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string AT-001
        $noakhir = 'LH-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
