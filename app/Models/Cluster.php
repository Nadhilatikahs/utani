<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cluster extends Model
{
    use HasFactory;
    

        public static function getClusterBiaya($start_date,$end_date)
    {
        // query kode bpp
        $sql = "SELECT a.kode_tanam,b.nama_komoditas,c.kode_lahan,
                ifnull(keuntungan,0) as keuntungan, 
                ifnull(beban_variabel,0) as beban_variabel, 
                ifnull(beban_fix,0) as beban_fix, 
                ifnull((keuntungan/(beban_variabel+beban_fix)),0) as rc 
                FROM tanams a join komoditas b on (a.id_komoditas=b.id_komoditas)
                join lahans c on (a.id_lahan=c.id_lahan)
                WHERE tgl_tanam>=? AND tgl_panen<=?";
        $bpps = DB::select($sql,[$start_date,$end_date]);

        return $bpps;

    }
    
}
