<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grafik extends Model
{
    public static function viewTahun(){
        $sql = "SELECT DISTINCT(DATE_FORMAT(tgl_panen,'%Y')) as tahun FROM tanams ORDER BY 1";
        $hasil = DB::select($sql);

        return $hasil;
    }
    
    // untuk mendapatkan view grafik per bulan berjalan
    public static function viewPenjualanSelectOption($tahun)
    {
        // query kode perusahaan
        $sql = "
                    SELECT a.wkt,
                           ifnull(b.total_keuntungan,0) as total_keuntungan,
                           ifnull(b.totan_beban_variabel,0) as total_beban_variabel,
                           ifnull(b.total_beban_fix,0) as total_beban_fix
                           FROM 
                        (SELECT concat(waktu,'-','".$tahun."') as wkt
                         FROM v_waktu_parameter 
                        ) a 
                    LEFT OUTER JOIN
                    (
                        SELECT DATE_FORMAT(tgl_panen,'%m-%Y') as waktu,
                                SUM(Keuntungan) as total_keuntungan,
                               SUM(beban_variabel) as totan_beban_variabel,
                               SUM(beban_fix) as total_beban_fix
                        FROM tanams
                        WHERE DATE_FORMAT(tgl_panen,'%Y') = ?
                        GROUP BY DATE_FORMAT(tgl_panen,'%m-%Y')
                    ) b
                    ON (a.wkt=b.waktu) 
                    ";
        $hasil = DB::select($sql,[$tahun]);

        return $hasil;

    }
    
    // untuk mendapatkan view grafik status komoditas
    public static function viewJmlPenjualan($tahun)
    {
        $sql = "SELECT nama_komoditas, SUM(Keuntungan) - SUM(beban_variabel) - SUM(beban_fix) as jml_penjualan 
                FROM tanams a JOIN komoditas b on (a.id_komoditas=b.id_komoditas)
                WHERE DATE_FORMAT(tgl_panen,'%Y') = ?
                GROUP BY  nama_komoditas";
        $hasil = DB::select($sql,[$tahun]);

        return $hasil;

    }
    
    // untuk mendapatkan view grafik status komoditas
    public static function viewKelompokTani($tahun)
    {
        $sql = "  SELECT nama_keltani, SUM(Keuntungan) - SUM(beban_variabel) - SUM(beban_fix) as jml_penjualan 
                FROM tanams a 
                JOIN lahans b on (a.id_lahan=b.id_lahan)
		        JOIN anggotatanis c on (b.id_anggota=c.id_anggota)
                JOIN kelompoktanis d on (c.id_keltani=d.id_keltani)
                WHERE DATE_FORMAT(tgl_panen,'%Y') = ?
                GROUP BY  nama_keltani";
        $hasil = DB::select($sql,[$tahun]);

        return $hasil;

    }
    
}
