<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kelompoktani extends Model
{
    use HasFactory;
    
    protected $table = "kelompoktanis";
    protected $primaryKey = "id_keltani";
    protected $fillable = [ 
        'id_keltani','kode_keltani','nama_keltani','alamat','latitude','longitude','id_desa'];



        public static function getKeltaniDetailDesa()
        {
           // query kode unit pelaksana teknis
        $sql = "SELECT a.*,b.nama_desa
                FROM kelompoktanis a
                JOIN desas b
                ON (a.id_desa=b.id_desa)";
        $kelompoktanis = DB::select($sql);

        return $kelompoktanis;
        }

        public static function getKodekeltani()
    {
        // query kode keltani
        $sql = "SELECT IFNULL(MAX(kode_keltani), 'KT-000') as kode_keltani
                FROM kelompoktanis";
        $kelompoktanis = DB::select($sql);

        // cacah hasilnya
        foreach ($kelompoktanis as $keltani) {
            $KT = $keltani->kode_keltani;
        }
        // Mengambil substring tiga digit akhir dari string KT-000
        $noawal = substr($KT,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string KT-001
        $noakhir = 'KT-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
