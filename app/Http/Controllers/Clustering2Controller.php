<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;

class Clustering2Controller extends Controller
{
    public function index()
    {
        // Ambil data gabungan dari beberapa tabel
        $data = DB::table('tanams')
            ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
            ->join('anggotatanis', 'lahans.id_anggota', '=', 'anggotatanis.id_anggota')
            ->join('kelompoktanis', 'anggotatanis.id_keltani', '=', 'kelompoktanis.id_keltani')
            ->select(
                'kelompoktanis.id_keltani',
                'kelompoktanis.nama_keltani',
                'kelompoktanis.latitude',
                'kelompoktanis.longitude',
                'tanams.keuntungan',
                'tanams.beban_variabel',
                'tanams.beban_fix'
            )
            ->get();

        // Hitung R/C dan kumpulkan data per kelompok tani
        $grouped = [];
        foreach ($data as $row) {
            $rc = ($row->beban_variabel + $row->beban_fix) != 0
                ? $row->keuntungan / ($row->beban_variabel + $row->beban_fix)
                : 0;

            $grouped[$row->id_keltani]['nama_keltani'] = $row->nama_keltani;
            $grouped[$row->id_keltani]['latitude'] = $row->latitude;
            $grouped[$row->id_keltani]['longitude'] = $row->longitude;
            $grouped[$row->id_keltani]['rc_list'][] = $rc;
        }

        // Ambil nilai rata-rata R/C tiap kelompok
        $dataset = [];
        $mapInfo = [];

        foreach ($grouped as $id_keltani => $info) {
            $avg_rc = count($info['rc_list']) > 0 ? array_sum($info['rc_list']) / count($info['rc_list']) : 0;

            $dataset[] = [$avg_rc]; // Untuk clustering
            $mapInfo[] = [
                'id_keltani' => $id_keltani,
                'nama_keltani' => $info['nama_keltani'],
                'latitude' => $info['latitude'],
                'longitude' => $info['longitude'],
                'rc' => $avg_rc
            ];
        }

        // Jalankan KMeans clustering
        $kmeans = new KMeans(3); // 3 cluster
        $clusters = $kmeans->cluster($dataset);

        // Tambahkan hasil cluster ke info kelompok
        $result = [];
        foreach ($clusters as $clusterIndex => $cluster) {
            foreach ($cluster as $point) {
                $index = array_search($point, $dataset);
                $info = $mapInfo[$index];
                $info['cluster'] = $clusterIndex + 1;
                $result[] = $info;
            }
        }

        return view('clustering.kelompok_tani', ['result' => $result]);
    }
}
