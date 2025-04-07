<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Komoditas extends Model
{
    use HasFactory;
    protected $table = "komoditas";
    protected $primaryKey = "id_komoditas";
    protected $fillable = [ 
        'id_komoditas','kode_komoditas','nama_komoditas','kategori','harga_satuan'];


        public static function getKodekomoditas()
    {
        // query kode komoditas
        $sql = "SELECT IFNULL(MAX(kode_komoditas), 'KD-000') as kode_komoditas
                FROM komoditas";
        $komoditas = DB::select($sql);

        // cacah hasilnya
        foreach ($komoditas as $komoditas) {
            $kd = $komoditas->kode_komoditas;
        }
        // Mengambil substring tiga digit akhir dari string KD-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string KD-001
        $noakhir = 'KD-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }

}
