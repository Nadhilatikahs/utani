<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Provinsi extends Model
{
    use HasFactory;
    protected $table='provinsis';
    protected $primaryKey = "id_provinsi";
    protected $fillable =[
        
        'kode_provinsi',
        'nama_provinsi',
        'latitude',
        'longitude'

    ];
    public static function getKodeprovinsi()
    {
        // query kode provinsi
        $sql = "SELECT IFNULL(MAX(kode_provinsi), 'PR-000') as kode_provinsi 
                FROM provinsis";
        $provinsis = DB::select($sql);

        // cacah hasilnya
        foreach ($provinsis as $kpr) {
            $pr = $kpr->kode_provinsi;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($pr,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'PR-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
    
    
}
