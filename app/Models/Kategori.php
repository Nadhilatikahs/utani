<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;
    protected $table = "kategori";
    protected $primaryKey = "id_kategori";
    protected $fillable = [ 'id_kategori','kode_kategori', 'keterangan',];



    public static function getKodekategori()
    {
        // query kode kategori
        $sql = "SELECT IFNULL(MAX(kode_kategori), 'K-000') as kode_kategori 
                FROM kategori";
        $kategori = DB::select($sql);

        // cacah hasilnya
        foreach ($kategori as $kat) {
            $kat = $kat->kode_kategori;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kat,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'K-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
