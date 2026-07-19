<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lahan extends Model
{
    use HasFactory;

    protected $table = "lahans";
    protected $primaryKey = "id_lahan";

    protected $fillable = [
        'id_lahan',
        'kode_lahan',
        'id_anggota',
        'luas',
        'jml_petak',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI ELOQUENT
    |--------------------------------------------------------------------------
    */

    /**
     * Petani pemilik lahan (tabel anggotatanis).
     * Dipakai dengan $lahan->petani.
     */
    public function petani()
    {
        return $this->belongsTo(Anggotatani::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Alias kalau di kode lama dipanggil $lahan->anggotatani.
     */
    public function anggotatani()
    {
        return $this->petani();
    }

    /**
     * Semua tanam yang dilakukan di lahan ini.
     */
    public function tanams()
    {
        return $this->hasMany(Tanam::class, 'id_lahan', 'id_lahan');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI LAMA BERBASIS QUERY MANUAL – DIBIARKAN
    |--------------------------------------------------------------------------
    */

    public static function getLahanDetailanggota()
    {
        // query lahan + nama anggota
        $sql = "SELECT a.*, b.nama_anggota as nama_anggota
                FROM lahans a
                JOIN anggotatanis b
                  ON (a.id_anggota = b.id_anggota)";

        $lahans = DB::select($sql);

        return $lahans;
    }

    public static function getKodelahan()
    {
        // query kode lahan terakhir
        $sql = "SELECT IFNULL(MAX(kode_lahan), 'LH-000') as kode_lahan
                FROM lahans";
        $lahans = DB::select($sql);

        foreach ($lahans as $lahan) {
            $lh = $lahan->kode_lahan;
        }

        // ambil 3 digit terakhir, increment, lalu format lagi
        $noawal  = substr($lh, -3);
        $noakhir = $noawal + 1;

        $noakhir = 'LH-' . str_pad($noakhir, 3, "0", STR_PAD_LEFT);

        return $noakhir;
    }
}
