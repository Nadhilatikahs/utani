<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Upt extends Model
{
    use HasFactory;
    protected $table = "upts";
    protected $primaryKey = "id_upt";
    protected $fillable = [ 
        'id_upt','kode_upt','nama_upt','alamat','latitude','longitude','id_dinas'];



        public static function getUptDetailDinas()
        {
           // query kode unit pelaksana teknis
        $sql = "SELECT a.*,b.nama_dinas
                FROM upts a
                JOIN dinas b
                ON (a.id_dinas=b.id_dinas)";
        $upts = DB::select($sql);

        return $upts;
        }

        public static function getKodeupt()
    {
        // query kode upt
        $sql = "SELECT IFNULL(MAX(kode_upt), 'UPT-000') as kode_upt
                FROM upts";
        $upts = DB::select($sql);

        // cacah hasilnya
        foreach ($upts as $upt) {
            $upt = $upt->kode_upt;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($upt,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'UPT-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
