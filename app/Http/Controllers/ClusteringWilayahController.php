<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;
use Illuminate\Support\Facades\DB;

class ClusteringWilayahController extends Controller
{
    public function index(Request $request)
    {
        // 1. Baca parameter kategori (default = desa)
        $kategori = $request->query('kategori', 'desa');

        // 2. Panggil data & clustering sesuai kategori
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

        // 3. Lakukan clustering (mengembalikan array ['nama','rc','cluster'])
        $result = $this->doClustering($dataRaw);

        // 4. Kirim ke view
        return view('clustering.index', [
            'result'   => $result,
            'kategori' => $kategori,
            'judul'    => $title,
        ]);
    }

    // Query per‐desa
    private function queryDesa()
    {
        return DB::table('tanams')
            ->join('lahans','tanams.id_lahan','=','lahans.id_lahan')
            ->join('anggotatanis','lahans.id_anggota','=','anggotatanis.id_anggota')
            ->join('kelompoktanis','anggotatanis.id_keltani','=','kelompoktanis.id_keltani')
            ->join('desas','kelompoktanis.id_desa','=','desas.id_desa')
            ->select(
                'desas.nama_desa as nama',
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya')
            )
            ->groupBy('desas.nama_desa')
            ->get();
    }

    // Query per‐kabupaten (sesuai relasi BPP → UPT → Dinas → Kabupaten)
    private function queryKabupaten()
    {
        return DB::table('tanams')
            ->join('lahans','tanams.id_lahan','=','lahans.id_lahan')
            ->join('anggotatanis','lahans.id_anggota','=','anggotatanis.id_anggota')
            ->join('kelompoktanis','anggotatanis.id_keltani','=','kelompoktanis.id_keltani')
            ->join('desas','kelompoktanis.id_desa','=','desas.id_desa')
            ->join('bpps','desas.id_bpp','=','bpps.id_bpp')
            ->join('upts','bpps.id_upt','=','upts.id_upt')
            ->join('dinas','upts.id_dinas','=','dinas.id_dinas')
            ->join('kabupatens','dinas.id_kabupaten','=','kabupatens.id_kabupaten')
            ->select(
                'kabupatens.nama_kabupaten as nama',
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya')
            )
            ->groupBy('kabupatens.nama_kabupaten')
            ->get();
    }

    // Query per‐UPT
    private function queryUPT()
    {
        return DB::table('tanams')
            ->join('lahans','tanams.id_lahan','=','lahans.id_lahan')
            ->join('anggotatanis','lahans.id_anggota','=','anggotatanis.id_anggota')
            ->join('kelompoktanis','anggotatanis.id_keltani','=','kelompoktanis.id_keltani')
            ->join('desas','kelompoktanis.id_desa','=','desas.id_desa')
            ->join('bpps','desas.id_bpp','=','bpps.id_bpp')
            ->join('upts','bpps.id_upt','=','upts.id_upt')
            ->select(
                'upts.nama_upt as nama',
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya')
            )
            ->groupBy('upts.nama_upt')
            ->get();
    }

    // Query per‐Komoditas
    private function queryKomoditas()
    {
        return DB::table('tanams')
            ->join('komoditas','tanams.id_komoditas','=','komoditas.id_komoditas')
            ->select(
                'komoditas.nama_komoditas as nama',
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya')
            )
            ->groupBy('komoditas.nama_komoditas')
            ->get();
    }

    // Fungsi umum melakukan clustering R/C
    private function doClustering($dataRaw)
    {
        $dataset = []; $labels = [];
        foreach ($dataRaw as $row) {
            $rc = $row->total_biaya
                ? $row->total_keuntungan / $row->total_biaya
                : 0;
            $dataset[] = [$rc];
            $labels[]  = $row->nama;
        }

        $clusters = (new KMeans(3))->cluster($dataset);
        $result = [];
        foreach ($clusters as $i => $cluster) {
            foreach ($cluster as $point) {
                $idx = array_search($point, $dataset);
                $result[] = [
                    'nama'    => $labels[$idx],
                    'rc'      => $point[0],
                    'cluster' => $i + 1,
                ];
            }
        }
        return $result;
    }
}
