<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Beban extends Model
{
    use HasFactory;
    protected $table='bebans';
    protected $primaryKey = "id_beban";
    protected $fillable =[
        'id_beban',
        'kode_beban',
        'nama_beban',
        'kategori',
        'id_kategori',
        
        
        
       
    ];


    public static function getBebanDetailkategori()
        {
           // query kode detail kategori
        $sql = "SELECT a.*,b.keterangan
                FROM bebans a
                JOIN kategori b
                ON (a.id_kategori=b.id_kategori)";
        $bebans = DB::select($sql);

        return $bebans;
        }



        public static function getKodebeban()
    {
        // query kode beban
        $sql = "SELECT IFNULL(MAX(kode_beban), 'BB-000') as kode_beban
                FROM bebans";
        $bebans = DB::select($sql);

        // cacah hasilnya
        foreach ($bebans as $bebans) {
            $bb = $bebans->kode_beban;
        }
        // Mengambil substring tiga digit akhir dari string KD-000
        $noawal = substr($bb,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string KD-001
        $noakhir = 'BB-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
