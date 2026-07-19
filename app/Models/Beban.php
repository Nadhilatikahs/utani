<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Beban extends Model
{
    use HasFactory;

    protected $table = 'bebans';
    protected $primaryKey = 'id_beban';

    protected $fillable = [
        'id_beban',
        'nama_beban',
        'kategori',        // variabel / fix / atau teks kategori
        'id_kategori',     // relasi ke master kategori (Keterangan: Beban Variabel / Beban Fix)
        'id_kelompok_biaya_produksi', // relasi ke master kelompok biaya produksi
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI (TETAP)
    |--------------------------------------------------------------------------
    */

    public function bebantanam()
    {
        return $this->hasMany(Bebantanam::class, 'id_beban', 'id_beban');
    }

    public function masterKategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function kelompokBiayaProduksi()
    {
        return $this->belongsTo(KelompokBiayaProduksi::class, 'id_kelompok_biaya_produksi', 'id_kelompok_biaya_produksi');
    }

    /*
    |--------------------------------------------------------------------------
    | UTIL: NORMALISASI JENIS PRODUKSI
    |--------------------------------------------------------------------------
    */

    public static function normalizeJenisProduksi(?string $value): string
    {
        $v = strtoupper(trim($value ?? ''));

        if (in_array($v, ['BBB', 'BTKL', 'BOP', 'LAIN'], true)) {
            return $v;
        }

        return 'LAIN';
    }

    /*
    |--------------------------------------------------------------------------
    | RULE-BASED CLASSIFIER (TANPA AI)
    |--------------------------------------------------------------------------
    */

    public static function guessJenisProduksi(
        ?string $namaBeban,
        ?string $kategoriText = null
    ): string {
        $text = mb_strtolower(trim(($namaBeban ?? '') . ' ' . ($kategoriText ?? '')));

        $contains = fn(string $needle) =>
            $needle !== '' && mb_strpos($text, mb_strtolower($needle)) !== false;

        // BBB – Bahan Baku Langsung
        if (
            $contains('benih') ||
            $contains('bibit') ||
            $contains('pupuk') ||
            $contains('herbisida') ||
            $contains('insektisida') ||
            $contains('fungisida') ||
            $contains('pestisida') ||
            $contains('obat')
        ) {
            return 'BBB';
        }

        // BTKL – Tenaga Kerja Langsung
        if (
            $contains('upah') ||
            $contains('gaji') ||
            $contains('buruh') ||
            $contains('tenaga kerja') ||
            $contains('tanam') ||
            $contains('panen') ||
            $contains('angkut')
        ) {
            return 'BTKL';
        }

        // BOP – Biaya Overhead Produksi
        if (
            $contains('sewa') ||
            $contains('alat') ||
            $contains('mesin') ||
            $contains('traktor') ||
            $contains('bbm') ||
            $contains('solar') ||
            $contains('bensin') ||
            $contains('listrik') ||
            $contains('pajak') ||
            $contains('retribusi')
        ) {
            return 'BOP';
        }

        return 'LAIN';
    }

    /*
    |--------------------------------------------------------------------------
    | SINGLE ENTRY POINT PENENTUAN JENIS_PRODUKSI
    |--------------------------------------------------------------------------
    */

    public static function resolveJenisProduksi(
        ?string $inputValue,
        ?string $namaBeban,
        ?string $kategoriText = null
    ): string {
        // 1️⃣ User isi manual → hormati
        if (!empty($inputValue)) {
            return self::normalizeJenisProduksi($inputValue);
        }

        // 2️⃣ Rule-based (default sekarang)
        return self::normalizeJenisProduksi(
            self::guessJenisProduksi($namaBeban, $kategoriText)
        );
    }

    public static function guessIdKelompokBiaya(
        ?string $namaBeban,
        ?string $kategoriText = null
    ): int {
        $jenis = self::guessJenisProduksi($namaBeban, $kategoriText);
        switch ($jenis) {
            case 'BBB':
                return 1;
            case 'BTKL':
                return 2;
            default:
                return 3; // BOP
        }
    }


    public static function suggestJenisProduksiWithAi(
        string $namaBeban,
        ?string $kategoriText = null
    ): ?string {
        // Future:
        // return app(BebanClassifierAi::class)
        //     ->classify($namaBeban, $kategoriText);

        return null;
    }


    public static function getBebanDetailkategori()
    {
        $sql = "SELECT a.*, b.keterangan as keterangan, c.nama_kelompok as kelompok_biaya
                FROM bebans a
                LEFT JOIN kategori b
                  ON (a.id_kategori = b.id_kategori)
                LEFT JOIN kelompok_biaya_produksis c
                  ON (a.id_kelompok_biaya_produksi = c.id_kelompok_biaya_produksi)
                ORDER BY a.kode_beban ASC";
        return DB::select($sql);
    }

    public static function getKodebeban()
    {
        $sql = "SELECT IFNULL(MAX(kode_beban), 'BB-000') as kode_beban
                FROM bebans";
        $bebans = DB::select($sql);

        foreach ($bebans as $beban) {
            $bb = $beban->kode_beban;
        }

        $noawal  = substr($bb, -3);
        $noakhir = (int)$noawal + 1;

        return 'BB-' . str_pad($noakhir, 3, '0', STR_PAD_LEFT);
    }
}
