<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tanam extends Model
{
    use HasFactory;
    protected $table = "tanams";
    protected $primaryKey = "id_tanam";
    protected $fillable = [ 
        'id_tanam','kode_tanam','id_lahan','id_komoditas','tgl_tanam','tgl_panen','volume_tanam','keuntungan','beban_variabel','beban_fix'];
        
        
       // Method untuk menghitung total beban dan mengupdate kolom beban_variabel
    //    public static function updateBebanVariabelFromBebanTanam()
    // {
    //     // Ambil data beban variabel dari tabel bebantanam
    //     $totalBebanTanam = BebanTanam::groupBy('id_tanam')
    //                                  ->selectRaw('id_tanam, SUM(total) as total')
    //                                  ->get();

    //     // Loop melalui setiap entri dan update/masukkan ke tabel tanam
    //     foreach ($totalBebanTanam as $item) {
    //         self::updateOrCreate(
    //             // ['id_tanam' => $item->id_tanam],
    //             ['kode_tanam' => $item->kode_tanam],
    //             ['id_lahan' => $item->id_lahan],
    //             ['id_komoditas' => $item->id_komoditas],
    //             ['beban_variabel' => $item->total]
    //         );
    //     }
    // }

    // public function updateBebanVariabel()
    // {
    //     // Mengambil total dari kolom 'total' dalam model Bebantanam
    //     $total = Bebantanam::sum('total');

    //     // Memasukkan nilai 'kode_tanam'
    //     $kode_tanam = $this->kode_tanam;    

    //     // Menetapkan nilai total ke dalam atribut 'beban_variabel'
    //     $this->beban_variabel = $total;
    //     $this->save();
    // }


    protected static function boot()
    {
        parent::boot();

        // Menggunakan event `creating` untuk menghitung hasil_panen sebelum membuat data baru
        static::creating(function ($model) {
            $model->keuntungan = $model->volume_panen - ($model->beban_variabel + $model->beban_fix);
        });

        // Menggunakan event `updating` untuk menghitung hasil_panen sebelum memperbarui data
        static::updating(function ($model) {
            $model->keuntungan = $model->volume_panen - ($model->beban_variabel + $model->beban_fix);
        });
    }

    public static function getTanamDetailtotal()
    {
       // query kode beban tanam
    $sql = "SELECT a.beban_variabel,b.total
            FROM tanams a
            JOIN bebantanam b
            ON (a.beban_variabel=b.total)";

          
    $tanams = DB::select($sql);

    return $tanams;
    }

    
    

        public static function getTanamDetaillahan()
        {
           // query kode beban tanam
        $sql = "SELECT a.*,b.kode_lahan
                FROM tanams a
                JOIN lahans b
                ON (a.id_lahan=b.id_lahan)";
        $tanams = DB::select($sql);

        return $tanams;
        }
        public static function getTanamDetailkomoditas()
        {
           // query kode beban tanam
        $sql = "SELECT a.*,b.nama_komoditas
                FROM tanams a
                JOIN komoditas b
                ON (a.id_komoditas=b.id_komoditas)";
        $tanams = DB::select($sql);

        return $tanams;
        }

        public static function getKodetanam()
    {
        // query kode tanam
        $sql = "SELECT IFNULL(MAX(kode_tanam), 'TM-000') as kode_tanam 
                FROM tanams";
        $tanams = DB::select($sql);

        // cacah hasilnya
        foreach ($tanams as $tanam) {
            $tm = $tanam->kode_tanam;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($tm,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'TM-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }
        
}
