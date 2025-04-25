<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;
use Illuminate\Support\Facades\DB;

class ClusteringWilayahController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori', 'desa'); // Default kategori adalah 'desa'

        // Menentukan judul dan query berdasarkan kategori yang dipilih
        switch ($kategori) {
            case 'kabupaten':
                $title = 'Per Kabupaten';
                $dataRaw = $this->queryKabupaten();
                break;
            case 'upt':
                $title = 'Per UPT';
                $dataRaw = $this->queryUPT();
                break;
            case 'komoditas':
                $title = 'Per Komoditas';
                $dataRaw = $this->queryKomoditas();
                break;
            case 'desa':
            default:
                $title = 'Per Desa';
                $dataRaw = $this->queryDesa();
                break;
        }

        $result = $this->doClustering($dataRaw, $kategori); // Passing kategori untuk menentukan nama yang sesuai

        return view('clustering.index', [
            'result'   => $result,
            'kategori' => $kategori,
            'judul'    => $title,
        ]);
    }

    private function queryDesa()
    {
        return DB::table('tanams')
            ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
            ->join('anggotatanis', 'lahans.id_anggota', '=', 'anggotatanis.id_anggota')
            ->join('kelompoktanis', 'anggotatanis.id_keltani', '=', 'kelompoktanis.id_keltani')
            ->join('desas', 'kelompoktanis.id_desa', '=', 'desas.id_desa')
            ->select(
                'desas.nama_desa as nama', // Nama yang ditampilkan sesuai kategori
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya'),
                DB::raw('AVG(desas.latitude) as latitude'),
                DB::raw('AVG(desas.longitude) as longitude')
            )
            ->groupBy('desas.nama_desa')
            ->get();
    }

    private function queryKabupaten()
    {
        return DB::table('tanams')
            ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
            ->join('anggotatanis', 'lahans.id_anggota', '=', 'anggotatanis.id_anggota')
            ->join('kelompoktanis', 'anggotatanis.id_keltani', '=', 'kelompoktanis.id_keltani')
            ->join('desas', 'kelompoktanis.id_desa', '=', 'desas.id_desa')
            ->join('bpps', 'desas.id_bpp', '=', 'bpps.id_bpp')
            ->join('upts', 'bpps.id_upt', '=', 'upts.id_upt')
            ->join('dinas', 'upts.id_dinas', '=', 'dinas.id_dinas')
            ->join('kabupatens', 'dinas.id_kabupaten', '=', 'kabupatens.id_kabupaten')
            ->select(
                'kabupatens.nama_kabupaten as nama', // Nama sesuai dengan kategori 'kabupaten'
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya'),
                DB::raw('AVG(kabupatens.latitude) as latitude'),
                DB::raw('AVG(kabupatens.longitude) as longitude')
            )
            ->groupBy('kabupatens.nama_kabupaten')
            ->get();
    }

    private function queryUPT()
    {
        return DB::table('tanams')
            ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
            ->join('anggotatanis', 'lahans.id_anggota', '=', 'anggotatanis.id_anggota')
            ->join('kelompoktanis', 'anggotatanis.id_keltani', '=', 'kelompoktanis.id_keltani')
            ->join('desas', 'kelompoktanis.id_desa', '=', 'desas.id_desa')
            ->join('bpps', 'desas.id_bpp', '=', 'bpps.id_bpp')
            ->join('upts', 'bpps.id_upt', '=', 'upts.id_upt')
            ->select(
                'upts.nama_upt as nama', // Nama sesuai dengan kategori 'upt'
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya'),
                DB::raw('AVG(upts.latitude) as latitude'),
                DB::raw('AVG(upts.longitude) as longitude')
            )
            ->groupBy('upts.nama_upt')
            ->get();
    }

    private function queryKomoditas()
    {
    return DB::table('tanams')
        ->join('komoditas', 'tanams.id_komoditas', '=', 'komoditas.id_komoditas')
        ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
        ->join('anggotatanis', 'lahans.id_anggota', '=', 'anggotatanis.id_anggota')
        ->select(
            'komoditas.nama_komoditas as nama', // Nama komoditas
            DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
            DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya'),
            DB::raw('AVG(anggotatanis.latitude) as latitude'),
            DB::raw('AVG(anggotatanis.longitude) as longitude')
        )
        ->groupBy('komoditas.nama_komoditas')
        ->get();
    }

    private function doClustering($dataRaw, $kategori)
    {
        $dataset   = [];
        $dataFinal = [];

        // Hitung R/C ratio dan siapkan data untuk clustering
        foreach ($dataRaw as $row) {
            $rc = $row->total_biaya > 0
                ? $row->total_keuntungan / $row->total_biaya
                : 0;

            $dataset[] = [$rc];
            $dataFinal[] = [
                'nama'      => $row->nama,
                'rc'        => round($rc, 2),
                'latitude'  => $row->latitude,
                'longitude' => $row->longitude,
            ];
        }

        // Jika dataset kosong, kembalikan array kosong
        if (empty($dataset)) {
            return [];
        }

        // Jalankan KMeans (3 cluster)
        $kmeans   = new KMeans(3);
        $clusters = $kmeans->cluster($dataset);

        // Gabungkan hasil cluster dengan dataFinal
        $result = [];
        foreach ($clusters as $clusterIndex => $points) {
            foreach ($points as $point) {
                foreach ($dataFinal as $key => $info) {
                    if ($info['rc'] === round($point[0], 2)) {
                        $result[] = array_merge($info, ['cluster' => $clusterIndex + 1]);
                        // Menghapus supaya tidak duplikat
                        unset($dataFinal[$key]);
                        break;
                    }
                }
            }
        }

        return $result;
    }
}