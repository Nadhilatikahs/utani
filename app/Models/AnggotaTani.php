<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Anggotatani extends Model
{
    use HasFactory;
    
    protected $table = "anggotatanis";
    protected $primaryKey = 'id_anggota';
    protected $fillable = [ 
        'id_anggota','kode_anggota','nama_anggota','nik','tempat_lahir','alamat','jenis_kelamin','no_hp','status_anggota','kategori_petani','latitude','longitude','id_keltani'];



        public static function getAnggotaDetailkeltani()
        {
           // query kode unit pelaksana teknis
        $sql = "SELECT a.*,b.nama_keltani
                FROM anggotatanis a
                JOIN kelompoktanis b
                ON (a.id_keltani=b.id_keltani)";
        $anggotatanis = DB::select($sql);

        return $anggotatanis;
        }

        public static function getKodeanggota()
    {
        // query kode anggota
        $sql = "SELECT IFNULL(MAX(kode_anggota), 'AT-000') as kode_anggota
                FROM anggotatanis";
        $anggotatanis = DB::select($sql);

        // cacah hasilnya
        foreach ($anggotatanis as $anggota) {
            $at = $anggota->kode_anggota;
        }
        // Mengambil substring tiga digit akhir dari string AT-000
        $noawal = substr($at,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string AT-001
        $noakhir = 'AT-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
}
