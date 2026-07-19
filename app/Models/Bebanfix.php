<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bebanfix extends Model
{
    use HasFactory;
    protected $table = "bebanfixes";
    protected $primaryKey = "id_bebanfix";
    protected $fillable = [
        'id_bebanfix','kode_beban_fix','keterangan','nominal'];

        public static function getKodebebanfix()
        {
            // query kode beban fix
            $sql = "SELECT IFNULL(MAX(kode_beban_fix), 'BF-000') as kode_beban_fix
                    FROM bebanfixes";
            $bebanfixes = DB::select($sql);

            // cacah hasilnya
            foreach ($bebanfixes as $beban) {
                $bb = $beban->kode_beban_fix;
            }
            // Mengambil substring tiga digit akhir dari string KD-000
            $noawal = substr($bb,-3);
            $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1

            //menyambung dengan string KD-001
            $noakhir = 'BF-'.str_pad($noakhir,3,"0",STR_PAD_LEFT);

            return $noakhir;

        }
}
