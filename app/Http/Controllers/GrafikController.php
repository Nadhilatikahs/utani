<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Dinas;
use App\Models\Upt;
use App\Models\Bpp;
use App\Models\Desa;
use App\Models\KelompokTani;
use App\Models\AnggotaTani;
use App\Models\Lahan;
use App\Models\Komoditas;
use App\Models\Beban;
use App\Models\Kategori;
use App\Models\Grafik;
use App\Models\Tanam;
use App\Models\Bebantanam;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        /*
         * 1) Counter data utama (tetap, sama seperti sebelumnya)
         */
        $provinsis      = Provinsi::count();
        $kabupatens     = Kabupaten::count();
        $dinas          = Dinas::count();
        $upts           = Upt::count();
        $bpps           = Bpp::count();
        $desas          = Desa::count();
        $kelompoktanis  = KelompokTani::count();
        $anggotatanis   = AnggotaTani::count();
        $lahans         = Lahan::count();
        $komoditas      = Komoditas::count();
        $bebans         = Beban::count();
        $kategori       = Kategori::count();

        /*
         * 2) Tahun aktif untuk filter dashboard
         */
        $tahun = $request->input('tahun', date('Y'));

        /*
         * 3) Ambil semua tanam di tahun tersebut (pakai tgl_panen, kalau kosong fallback ke tgl_tanam)
         */
        $tanamQuery = Tanam::with(['panens', 'bebantanam', 'komoditas']);

        $tanamTahun = (clone $tanamQuery)
            ->whereYear('tgl_panen', $tahun)
            ->get();

        if ($tanamTahun->isEmpty()) {
            // fallback kalau tgl_panen null / belum terisi
            $tanamTahun = (clone $tanamQuery)
                ->whereYear('tgl_tanam', $tahun)
                ->get();
        }

        /*
         * 4) Ringkasan keuangan untuk card di atas
         *
         * total_pendapatan  = sum total_pendapatan tiap tanam (akses dari accessor Tanam)
         * total_biaya       = sum total_biaya
         * total_laba        = sum keuntungan_aktual
         */
        $totalPendapatan = $tanamTahun->sum(fn (Tanam $t) => $t->total_pendapatan);
        $totalBiaya      = $tanamTahun->sum(fn (Tanam $t) => $t->total_biaya);
        $totalLaba       = $tanamTahun->sum(fn (Tanam $t) => $t->keuntungan_aktual);

        $summaryKeuangan = [
            'tahun'            => (int) $tahun,
            'total_pendapatan' => (float) $totalPendapatan,
            'total_biaya'      => (float) $totalBiaya,
            'total_laba'       => (float) $totalLaba,
        ];

        /*
         * 5) Data pie: "Komoditas Terlaris (Pendapatan)"
         *
         * Kelompok per komoditas => sum pendapatan / biaya / laba
         */
        $grafikBiayaPerKomoditas = [];

        if ($tanamTahun->isNotEmpty()) {
            $groupedByKomoditas = $tanamTahun->groupBy(function (Tanam $t) {
                return optional($t->komoditas)->nama_komoditas ?: 'Tidak diketahui';
            });

            foreach ($groupedByKomoditas as $namaKomoditas => $items) {
                $pendapatan = $items->sum(fn (Tanam $t) => $t->total_pendapatan);
                $biaya      = $items->sum(fn (Tanam $t) => $t->total_biaya);
                $laba       = $items->sum(fn (Tanam $t) => $t->keuntungan_aktual);

                $grafikBiayaPerKomoditas[] = [
                    'label'      => $namaKomoditas,
                    'pendapatan' => (float) $pendapatan,
                    'biaya'      => (float) $biaya,
                    'laba'       => (float) $laba,
                ];
            }
        }

        // 6) Data line: pendapatan / biaya / laba per bulan
        $grafikLabaPerBulan = [];

        if ($tanamTahun->isNotEmpty()) {
            // Kelompokkan per bulan (pakai tgl_panen, kalau null pakai tgl_tanam)
            $groupedByMonth = $tanamTahun->groupBy(function (Tanam $t) {
                $tanggal = $t->tgl_panen ?? $t->tgl_tanam;
                if (! $tanggal) {
                    return null;
                }

                if (! $tanggal instanceof \Carbon\Carbon) {
                    $tanggal = \Carbon\Carbon::parse($tanggal);
                }

                return (int) $tanggal->format('n'); // 1-12
            })->filter(function ($items, $month) {
                return ! is_null($month);
            })
            ->sortKeys(); // ✅ pakai Collection::sortKeys(), bukan ksort()

            $monthLabels = [
                1  => 'Jan',
                2  => 'Feb',
                3  => 'Mar',
                4  => 'Apr',
                5  => 'Mei',
                6  => 'Jun',
                7  => 'Jul',
                8  => 'Agu',
                9  => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des',
            ];

            foreach ($groupedByMonth as $month => $items) {
                $pendapatan = $items->sum(fn (Tanam $t) => $t->total_pendapatan);
                $biaya      = $items->sum(fn (Tanam $t) => $t->total_biaya);
                $laba       = $items->sum(fn (Tanam $t) => $t->keuntungan_aktual);

                $grafikLabaPerBulan[] = [
                    'label'      => $monthLabels[$month] ?? 'Bulan '.$month,
                    'pendapatan' => (float) $pendapatan,
                    'biaya'      => (float) $biaya,
                    'laba'       => (float) $laba,
                ];
            }
        }

        /*
         * 7) Cash Flow Data (Arus Kas Per Bulan)
         */
        $cashFlowData = $this->getCashFlowData($tahun);

        /*
         * 8) Top 3 Expenses This Month
         */
        $topExpenses = $this->getTopExpenses($tahun);

        /*
         * 9) Transaction Summary
         */
        $transactionSummary = $this->getTransactionSummary($tahun);

        /*
         * 10) Cluster Data for Map (filtered by year)
         */
        $clusterData = $this->getClusterData($tahun);

        /*
         * 11) Grafik Kelompok Tani Data
         */
        $grafikKelompokTani = $this->getGrafikKelompokTani($tahun);

        /*
         * 12) Summary Statistics for the Year
         */
        $totalTanamTahun = $tanamTahun->count();

        /*
         * 13) Kirim semua data ke view dashboard
         */
        return view('dashboard', compact(
            'provinsis',
            'kabupatens',
            'dinas',
            'upts',
            'bpps',
            'desas',
            'kelompoktanis',
            'anggotatanis',
            'lahans',
            'komoditas',
            'bebans',
            'kategori',
            'summaryKeuangan',
            'grafikBiayaPerKomoditas',
            'grafikLabaPerBulan',
            'cashFlowData',
            'topExpenses',
            'transactionSummary',
            'clusterData',
            'grafikKelompokTani',
            'totalTanamTahun',
        ));
    }

    private function getCashFlowData($tahun)
    {
        $tanamQuery = Tanam::with(['panens', 'bebantanam']);
        $tanamTahun = (clone $tanamQuery)->whereYear('tgl_panen', $tahun)->get();
        
        if ($tanamTahun->isEmpty()) {
            $tanamTahun = (clone $tanamQuery)->whereYear('tgl_tanam', $tahun)->get();
        }

        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $cashFlow = [];

        if ($tanamTahun->isNotEmpty()) {
            $groupedByMonth = $tanamTahun->groupBy(function (Tanam $t) {
                $tanggal = $t->tgl_panen ?? $t->tgl_tanam;
                if (!$tanggal) return null;
                if (!$tanggal instanceof \Carbon\Carbon) {
                    $tanggal = \Carbon\Carbon::parse($tanggal);
                }
                return (int) $tanggal->format('n');
            })->filter(fn($items, $month) => !is_null($month))->sortKeys();

            foreach ($groupedByMonth as $month => $items) {
                $uangMasuk = $items->sum(fn(Tanam $t) => $t->total_pendapatan);
                $uangKeluar = $items->sum(fn(Tanam $t) => $t->total_biaya);
                $sisaUntung = $uangMasuk - $uangKeluar;

                $cashFlow[] = [
                    'label' => $monthLabels[$month - 1] ?? 'Bulan ' . $month,
                    'uang_masuk' => (float) $uangMasuk,
                    'uang_keluar' => (float) $uangKeluar,
                    'sisa_untung' => (float) $sisaUntung,
                ];
            }
        }

        return $cashFlow;
    }

    private function getTopExpenses($tahun)
    {
        // Get top expenses for the entire year, using tgl_panen or fallback to tgl_tanam
        $topBeban = Bebantanam::join('tanams', 'bebantanam.id_tanam', '=', 'tanams.id_tanam')
            ->join('bebans', 'bebantanam.id_beban', '=', 'bebans.id_beban')
            ->where(function($query) use ($tahun) {
                $query->whereYear('tanams.tgl_panen', $tahun)
                      ->orWhere(function($q) use ($tahun) {
                          $q->whereNull('tanams.tgl_panen')
                            ->whereYear('tanams.tgl_tanam', $tahun);
                      });
            })
            ->select(
                'bebans.nama_beban',
                DB::raw('SUM(bebantanam.total) as total_biaya')
            )
            ->groupBy('bebans.nama_beban', 'bebans.id_beban')
            ->orderByDesc('total_biaya')
            ->limit(3)
            ->get();

        return $topBeban->map(function($item) {
            return [
                'nama' => $item->nama_beban,
                'total' => (float) $item->total_biaya,
            ];
        })->toArray();
    }

    private function getTransactionSummary($tahun)
    {
        $transactions = Transaction::whereYear('tgl_transaksi', $tahun)->get();
        
        $total = $transactions->count();
        $pending = $transactions->where('status', 0)->count();
        $verified = $transactions->where('status', 1)->count();
        $totalAmount = $transactions->where('status', 1)->sum('total');

        return [
            'total' => $total,
            'pending' => $pending,
            'verified' => $verified,
            'total_amount' => (float) $totalAmount,
        ];
    }

    private function getClusterData($tahun)
    {
        // Get cluster data filtered by year (using tgl_panen or fallback to tgl_tanam)
        $dataRaw = DB::table('tanams')
            ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
            ->join('anggotatanis', 'lahans.id_anggota', '=', 'anggotatanis.id_anggota')
            ->join('kelompoktanis', 'anggotatanis.id_keltani', '=', 'kelompoktanis.id_keltani')
            ->join('desas', 'kelompoktanis.id_desa', '=', 'desas.id_desa')
            ->where(function($query) use ($tahun) {
                $query->whereYear('tanams.tgl_panen', $tahun)
                      ->orWhere(function($q) use ($tahun) {
                          $q->whereNull('tanams.tgl_panen')
                            ->whereYear('tanams.tgl_tanam', $tahun);
                      });
            })
            ->select(
                'desas.nama_desa as nama',
                DB::raw('SUM(tanams.keuntungan) as total_keuntungan'),
                DB::raw('SUM(tanams.beban_variabel + tanams.beban_fix) as total_biaya'),
                DB::raw('AVG(desas.latitude) as latitude'),
                DB::raw('AVG(desas.longitude) as longitude')
            )
            ->groupBy('desas.nama_desa')
            ->get();

        $clusterData = [];
        foreach ($dataRaw as $row) {
            $rc = $row->total_biaya > 0 ? $row->total_keuntungan / $row->total_biaya : 0;
            
            // Simple clustering: High (RC > 1.5), Medium (0.5 < RC <= 1.5), Low (RC <= 0.5)
            $cluster = $rc > 1.5 ? 'high' : ($rc > 0.5 ? 'medium' : 'low');
            
            $clusterData[] = [
                'nama' => $row->nama,
                'latitude' => (float) ($row->latitude ?? 0),
                'longitude' => (float) ($row->longitude ?? 0),
                'rc' => round($rc, 2),
                'cluster' => $cluster,
            ];
        }

        return $clusterData;
    }

    private function getGrafikKelompokTani($tahun)
    {
        $data = Grafik::viewKelompokTani($tahun);
        
        return collect($data)->map(function($item) {
            return [
                'nama' => $item->nama_keltani,
                'pendapatan' => (float) ($item->jml_penjualan ?? 0),
            ];
        })->sortByDesc('pendapatan')->take(10)->values()->toArray();
    }

    // =====================
    // FUNGSI LAMA: BIARKAN
    // =====================

    // Grafik pilihtahunbatang
    public function pilihtahunbatang($tahun)
    {
        $daftartahun = Grafik::viewTahun();
        $grafik      = Grafik::viewPenjualanSelectOption($tahun);

        return view('grafik.pilihtahunbatang', [
            'grafik'      => $grafik,
            'daftartahun' => $daftartahun,
        ]);
    }

    // viewDataPenjualanSelectOption
    public function viewDataPenjualanSelectOption($tahun)
    {
        $grafik = Grafik::viewPenjualanSelectOption($tahun);

        return response()->json([
            'grafik' => $grafik,
        ]);
    }

    // view status penjualan
    public function viewJmlPenjualan($tahun)
    {
        $daftartahun = Grafik::viewTahun();
        $grafik      = Grafik::viewJmlPenjualan($tahun);

        return view('grafik.pie', [
            'grafik'      => $grafik,
            'daftartahun' => $daftartahun,
        ]);
    }

    public function viewJmlPenjualanJson($tahun)
    {
        $grafik = Grafik::viewJmlPenjualan($tahun);

        return response()->json([
            'grafik' => $grafik,
        ]);
    }

    // view kelompok tani
    public function viewJmlPendapatanKelompokTani($tahun)
    {
        $daftartahun = Grafik::viewTahun();
        $grafik      = Grafik::viewKelompokTani($tahun);

        return view('grafik.piekelompoktani', [
            'grafik'      => $grafik,
            'daftartahun' => $daftartahun,
        ]);
    }

    public function viewJmlPendapatanKelompokTaniJson($tahun)
    {
        $grafik = Grafik::viewKelompokTani($tahun);

        return response()->json([
            'grafik' => $grafik,
        ]);
    }
}
