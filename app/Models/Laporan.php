<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laporan extends Model
{
    use HasFactory;

    public static function getdata1() {
        return DB::table('bebans')
                 ->select('nama_beban')
                 ->where('kategori', 'persiapan lahan')
                 ->get();

}

public static function getdata2() {
    return DB::table('komoditas')
             ->select('nama_komoditas')
         
             ->get();

}


}
