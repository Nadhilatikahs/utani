<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bpp extends Model
{
    use HasFactory;
    
    protected $table = "bpps";
    protected $primaryKey = "id_bpp";
    protected $fillable = [ 
        'id_bpp','kode_bpp','nama_bpp','alamat','latitude','longitude','id_upt'];



        public static function getBppDetailUpt()
        {
           // query kode unit pelaksana teknis
        $sql = "SELECT a.*,b.nama_upt
                FROM bpps a
                JOIN upts b
                ON (a.id_upt=b.id_upt)";
        $bpps = DB::select($sql);

        return $bpps;
        }

        public static function getKodebpp()
    {
        // query kode bpp
        $sql = "SELECT IFNULL(MAX(kode_bpp), 'BPP-000') as kode_bpp
                FROM bpps";
        $bpps = DB::select($sql);

        // cacah hasilnya
        foreach ($bpps as $bpp) {
            $bpp = $bpp->kode_bpp;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($bpp,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'BPP-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
    
}
