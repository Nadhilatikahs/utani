<?php

namespace App\Http\Controllers;

use App\Models\Tanam;
use App\Models\Beban;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // pdf

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan:
     * - Menampilkan list Tanam untuk dipilih.
     * - Menampilkan ringkasan semua usaha tani.
     */
    public function index()
    {
        $tanams = Tanam::with([
                'komoditas',
                'lahan.petani',
                'panens',
                'bebantanam.beban.masterKategori',
            ])
            ->orderByDesc('tgl_tanam')
            ->get();

        return view('laporan.index', compact('tanams'));
    }

    /**
     * Tampilkan laporan biaya produksi berdasarkan komoditas.
     * Menampilkan total biaya per komoditas dengan kemampuan melihat detail per tanam.
     */
    public function byCommodity()
    {
        $tanams = Tanam::with([
                'komoditas',
                'lahan.petani',
                'panens',
                'bebantanam.beban.masterKategori',
            ])
            ->orderByDesc('tgl_tanam')
            ->get();

        // Group by commodity
        $commodityGroups = [];
        
        foreach ($tanams as $tanam) {
            $komoditasId = $tanam->id_komoditas;
            $komoditasName = $tanam->komoditas->nama_komoditas ?? 'Unknown';
            
            if (!isset($commodityGroups[$komoditasId])) {
                $commodityGroups[$komoditasId] = [
                    'id_komoditas' => $komoditasId,
                    'nama_komoditas' => $komoditasName,
                    'kode_komoditas' => $tanam->komoditas->kode_komoditas ?? '-',
                    'tanams' => [],
                    'total_pendapatan' => 0,
                    'total_biaya_variabel' => 0,
                    'total_biaya_tetap' => 0,
                    'total_biaya' => 0,
                    'total_bbb' => 0,
                    'total_btkl' => 0,
                    'total_bop' => 0,
                    'total_biaya_produksi' => 0,
                    'total_keuntungan' => 0,
                    'total_volume' => 0,
                    'jumlah_tanam' => 0,
                ];
            }
            
            $pendapatan = $tanam->total_pendapatan;
            $biayaVar = $tanam->total_biaya_variabel;
            $biayaTetap = $tanam->total_biaya_tetap;
            $totalBiaya = $tanam->total_biaya;
            $keuntungan = $tanam->keuntungan_aktual;
            
            // Calculate components
            $bbb = 0;
            $btkl = 0;
            $bop = 0;

            foreach ($tanam->bebantanam as $bt) {
                $beban = $bt->beban;
                if (!$beban) continue;
                
                $kelompok = Beban::resolveJenisProduksi(
                    null,
                    $beban->nama_beban,
                    $beban->kategori,
                );
                
                $total = !is_null($bt->total) ? (float) $bt->total : (float) $bt->jumlah * (float) $bt->harga;
                
                if ($kelompok === 'BBB') {
                    $bbb += $total;
                } elseif ($kelompok === 'BTKL') {
                    $btkl += $total;
                } elseif ($kelompok === 'BOP' || $kelompok === 'LAIN') {
                    // Grouping LAIN into BOP depending on how strict it should be, 
                    // but the requirement says Total Biaya Produksi = BBB + BTKL + BOP
                    // So we lump other production costs into BOP for this report
                    $bop += $total;
                }
            }
            
            $totalBiayaProduksiTanam = $bbb + $btkl + $bop;
            
            // Calculate volume
            $volume = $tanam->panens->sum(function ($p) {
                return (float) ($p->jumlah ?? 0);
            });
            
            if (!$volume) {
                $volume = $tanam->volume_tanam ?? 0;
            }
            
            $commodityGroups[$komoditasId]['tanams'][] = [
                'tanam' => $tanam,
                'pendapatan' => $pendapatan,
                'biaya_variabel' => $biayaVar,
                'biaya_tetap' => $biayaTetap,
                'total_biaya' => $totalBiaya,
                'bbb' => $bbb,
                'btkl' => $btkl,
                'bop' => $bop,
                'total_biaya_produksi' => $totalBiayaProduksiTanam,
                'keuntungan' => $keuntungan,
                'volume' => $volume,
            ];
            
            $commodityGroups[$komoditasId]['total_pendapatan'] += $pendapatan;
            $commodityGroups[$komoditasId]['total_biaya_variabel'] += $biayaVar;
            $commodityGroups[$komoditasId]['total_biaya_tetap'] += $biayaTetap;
            $commodityGroups[$komoditasId]['total_biaya'] += $totalBiaya;
            $commodityGroups[$komoditasId]['total_bbb'] += $bbb;
            $commodityGroups[$komoditasId]['total_btkl'] += $btkl;
            $commodityGroups[$komoditasId]['total_bop'] += $bop;
            $commodityGroups[$komoditasId]['total_biaya_produksi'] += $totalBiayaProduksiTanam;
            $commodityGroups[$komoditasId]['total_keuntungan'] += $keuntungan;
            $commodityGroups[$komoditasId]['total_volume'] += $volume;
            $commodityGroups[$komoditasId]['jumlah_tanam']++;
        }
        
        // Sort by total biaya descending
        usort($commodityGroups, function($a, $b) {
            return $b['total_biaya'] <=> $a['total_biaya'];
        });

        return view('laporan.by_commodity', compact('commodityGroups'));
    }

    /**
     * Tampilkan laporan detail untuk satu Tanam (versi HTML).
     */
    public function show(Request $request)
    {
        $tanamId = $request->get('tanam_id');

        if (! $tanamId) {
            return redirect()
                ->route('laporan.index')
                ->with('error', 'Silakan pilih salah satu data tanam terlebih dahulu.');
        }

        $tanam = Tanam::with([
                'komoditas',
                'lahan.petani',
                'panens',
                'bebantanam.beban.masterKategori',
            ])
            ->findOrFail($tanamId);

        $biayaProduksi    = $this->buildBiayaProduksi($tanam);
        $marginKontribusi = $this->buildMarginKontribusi($tanam);

        return view('laporan.show', [
            'tanam'            => $tanam,
            'biayaProduksi'    => $biayaProduksi,
            'marginKontribusi' => $marginKontribusi,
        ]);
    }

    /**
     * Export laporan satu usaha tani ke PDF.
     */
    public function print(Request $request)
    {
        $tanamId = $request->get('tanam_id');

        if (! $tanamId) {
            return redirect()
                ->route('laporan.index')
                ->with('error', 'Silakan pilih salah satu data tanam terlebih dahulu.');
        }

        $tanam = Tanam::with([
                'komoditas',
                'lahan.petani',
                'panens',
                'bebantanam.beban.masterKategori',
            ])
            ->findOrFail($tanamId);

        $biayaProduksi    = $this->buildBiayaProduksi($tanam);
        $marginKontribusi = $this->buildMarginKontribusi($tanam);

        $pdf = Pdf::loadView('laporan.print', [
                'tanam'            => $tanam,
                'biayaProduksi'    => $biayaProduksi,
                'marginKontribusi' => $marginKontribusi,
            ])
            ->setPaper('a4', 'landscape');

        $filename = 'laporan_usahatani_'.$tanam->kode_tanam.'.pdf';

        if (ob_get_length()) {
            ob_end_clean();
        }

        return $pdf->download($filename);
    }

    /**
     * Print-preview page — opens a clean print-layout in browser,
     * auto-triggers window.print() so user can "Save as PDF".
     */
    public function preview($tanam_id)
    {
        $tanam = Tanam::with([
                'komoditas',
                'lahan.petani',
                'panens',
                'bebantanam.beban.masterKategori',
            ])
            ->findOrFail($tanam_id);

        $biayaProduksi    = $this->buildBiayaProduksi($tanam);
        $marginKontribusi = $this->buildMarginKontribusi($tanam);

        return view('laporan.pdf_preview', [
            'tanam'            => $tanam,
            'biayaProduksi'    => $biayaProduksi,
            'marginKontribusi' => $marginKontribusi,
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | LOGIC LAPORAN BIAYA PRODUKSI
    |----------------------------------------------------------------------
    */
    protected function buildBiayaProduksi(Tanam $tanam): array
    {
        $pendapatan = $tanam->total_pendapatan;
        $biayaVar   = $tanam->total_biaya_variabel;
        $biayaTetap = $tanam->total_biaya_tetap;
        $totalBiaya = $tanam->total_biaya;
        $laba       = $tanam->keuntungan_aktual;

        // Volume panen:
        // - kalau tidak ada panen → fallback ke volume_tanam
        $volume = $tanam->panens->sum(function ($p) {
            return (float) ($p->jumlah ?? 0);
        });

        if (! $volume) {
            $volume = $tanam->volume_tanam ?? 0;
        }

        $cmpu = $volume > 0 ? $totalBiaya / $volume : null;

        // Rekap biaya per kelompok biaya produksi (BBB / BTKL / BOP / LAIN)
        $detailByKategori = [
            'BBB'  => ['items' => [], 'subtotal' => 0],
            'BTKL' => ['items' => [], 'subtotal' => 0],
            'BOP'  => ['items' => [], 'subtotal' => 0],
            'LAIN' => ['items' => [], 'subtotal' => 0],
        ];

        foreach ($tanam->bebantanam as $bt) {
            $beban = $bt->beban;

            if (! $beban) {
                continue;
            }

            // tentukan BBB / BTKL / BOP / LAIN
            $kelompok = Beban::resolveJenisProduksi(
                null,
                $beban->nama_beban,
                $beban->kategori,
            );

            if (! array_key_exists($kelompok, $detailByKategori)) {
                $kelompok = 'LAIN';
            }

            $total = ! is_null($bt->total)
                ? (float) $bt->total
                : (float) $bt->jumlah * (float) $bt->harga;

            $detailByKategori[$kelompok]['items'][] = [
                'kode_beban' => $beban->kode_beban ?? null,
                'nama_beban' => $beban->nama_beban ?? null,
                'satuan'     => $bt->satuan,
                'jumlah'     => $bt->jumlah,
                'harga'      => $bt->harga,
                'total'      => $total,
            ];

            $detailByKategori[$kelompok]['subtotal'] += $total;
        }

        // Nama petani dari relasi lahan->petani
        $petaniObj = optional(optional($tanam->lahan)->petani);
        $petaniName = $petaniObj->nama_anggota
            ?? $petaniObj->nama_petani
            ?? '-';

        return [
            'tanam' => [
                'kode_tanam' => $tanam->kode_tanam,
                'komoditas'  => $tanam->komoditas->nama_komoditas ?? '-',
                'petani'     => $petaniName,
                'volume'     => $volume,
            ],
            'ringkasan' => [
                'pendapatan'  => $pendapatan,
                'biaya_var'   => $biayaVar,
                'biaya_tetap' => $biayaTetap,
                'total_biaya' => $totalBiaya,
                'keuntungan'  => $laba,
                'cmpu'        => $cmpu,
            ],
            'detail_biaya' => $detailByKategori,
        ];
    }

    /*
    |----------------------------------------------------------------------
    | LOGIC LAPORAN KEUNTUNGAN & KERUGIAN / MARGIN KONTRIBUSI
    |----------------------------------------------------------------------
    */
    protected function buildMarginKontribusi(Tanam $tanam): array
    {
        $pendapatan = $tanam->total_pendapatan;
        $biayaVar   = $tanam->total_biaya_variabel;
        $biayaTetap = $tanam->total_biaya_tetap;
        $totalBiaya = $tanam->total_biaya;
        $laba       = $tanam->keuntungan_aktual;

        // Hitung volume panen
        $volume = $tanam->panens->sum(function ($p) {
            return (float) ($p->jumlah ?? 0);
        });

        if (! $volume) {
            $volume = $tanam->volume_tanam ?? 0;
        }

        // Harga & biaya per unit
        $hargaPerUnit = $volume > 0 ? $pendapatan / $volume : null;
        $biayaVariabelPerUnit = ($volume ?? 0) > 0 ? $biayaVar / $volume : 0;
        $biayaVarPerU = $biayaVariabelPerUnit; // Keep original variable for compatibility

        $bvTotalFormatted   = number_format($biayaVar, 0, ',', '.');
        $jumlahFormatted    = number_format($volume, 0, ',', '.');
        $bvFormulaText      = $bvTotalFormatted . ' / ' . $jumlahFormatted;

        // Contribution Margin
        $marginTotal   = $pendapatan - $biayaVar;
        $marginPerUnit = ($hargaPerUnit !== null && $biayaVarPerU !== null)
            ? $hargaPerUnit - $biayaVarPerU
            : null;

        // Contribution Margin Ratio
        $cmRatio = $pendapatan > 0
            ? $marginTotal / $pendapatan
            : null;

        // BEP
        $bepUnit = ($marginPerUnit !== null && $marginPerUnit > 0)
            ? $biayaTetap / $marginPerUnit
            : null;

        // BEP Rupiah (AKUNTANSI BENAR)
        $bepRupiah = ($cmRatio !== null && $cmRatio > 0)
            ? $biayaTetap / $cmRatio
            : null;

        // Status laba
        if ($laba > 0) {
            $status = 'Untung';
        } elseif ($laba < 0) {
            $status = 'Rugi';
        } else {
            $status = 'Impas';
        }

        // Statistik risiko & kegagalan panen:
        // - failed_harvest_count: jumlah panen dengan status gagal_sebagian / gagal_total
        // - risk_harvest_count: jumlah panen gagal_sebagian
        // - failed_harvest_loss: pendekatan kerugian = max(0, total_biaya - pendapatan)
        $failedPanens = $tanam->panens->whereIn('status_panen', ['gagal_sebagian', 'gagal_total']);
        $riskPanens   = $tanam->panens->where('status_panen', 'gagal_sebagian');

        $failedCount = $failedPanens->count();
        $riskCount   = $riskPanens->count();
        $totalLoss   = max(0, $totalBiaya - $pendapatan);

        $petaniObj = optional(optional($tanam->lahan)->petani);
        $petaniName = $petaniObj->nama_anggota
            ?? $petaniObj->nama_petani
            ?? '-';

        // Kumpulkan item-item Biaya Tetap (kategori keterangan: 'Beban Fix')
        $bebanFixItems = [];
        $hasKlasifikasi = \DB::table('bebantanam as bt')
            ->join('bebans as b', 'b.id_beban', '=', 'bt.id_beban')
            ->join('kategori as k', 'k.id_kategori', '=', 'b.id_kategori')
            ->where('bt.id_tanam', $tanam->id_tanam)
            ->where(function ($q) {
                $q->where('k.keterangan', 'like', 'Beban Variabel%')
                  ->orWhere('k.keterangan', 'like', 'Beban Fix%');
            })
            ->count();

        if ($hasKlasifikasi > 0) {
            $fixRows = \DB::table('bebantanam as bt')
                ->join('bebans as b', 'b.id_beban', '=', 'bt.id_beban')
                ->join('kategori as k', 'k.id_kategori', '=', 'b.id_kategori')
                ->where('bt.id_tanam', $tanam->id_tanam)
                ->where('k.keterangan', 'like', 'Beban Fix%')
                ->select('b.nama_beban', 'bt.jumlah', 'bt.harga', 'bt.total')
                ->get();

            foreach ($fixRows as $row) {
                $total = ! is_null($row->total)
                    ? (float) $row->total
                    : (float) ($row->jumlah ?? 0) * (float) ($row->harga ?? 0);

                $bebanFixItems[] = [
                    'nama_beban' => $row->nama_beban,
                    'total'      => $total,
                ];
            }
        }

        // Flat List Cost Classification
        $biayaVariabelItems = [];
        $totalBiayaVariabel = 0;

        $biayaTetapItems = [];
        $totalBiayaTetap = 0;

        foreach ($tanam->bebantanam as $bt) {
            $beban = $bt->beban;
            if (! $beban) {
                continue;
            }

            $kategori = strtolower($beban->masterKategori->keterangan ?? '');
            $isVariable = str_contains($kategori, 'variabel');
            $isFixed    = str_contains($kategori, 'fix') || str_contains($kategori, 'tetap');

            $nominal = $bt->total ?? 0;

            if ($isVariable) {
                $biayaVariabelItems[] = [
                    'nama'  => $beban->nama_beban ?? $beban->nama ?? '-',
                    'total' => $nominal
                ];
                $totalBiayaVariabel += $nominal;
            } elseif ($isFixed) {
                $biayaTetapItems[] = [
                    'nama'  => $beban->nama_beban ?? $beban->nama ?? '-',
                    'total' => $nominal
                ];
                $totalBiayaTetap += $nominal;
            }
        }

        return [
            'tanam' => [
                'kode_tanam' => $tanam->kode_tanam,
                'komoditas'  => $tanam->komoditas->nama_komoditas ?? '-',
                'petani'     => $petaniName,
                'volume'     => $volume,
            ],
            'nilai' => [
                'pendapatan'           => $pendapatan,
                'biaya_variabel_items' => $biayaVariabelItems,
                'total_biaya_variabel' => $totalBiayaVariabel,
                'biaya_tetap_items'    => $biayaTetapItems,
                'total_biaya_tetap'    => $totalBiayaTetap,
                'total_biaya'          => $totalBiaya,
                'laba_bersih'          => $laba,
                'margin_total'         => $marginTotal,
                'harga_per_unit'       => $hargaPerUnit,
                'biaya_variabel_unit'  => $biayaVarPerU,
                'bv_formula_text'      => $bvFormulaText,
                'margin_per_unit'      => $marginPerUnit,
                'cm_ratio'             => $cmRatio,
                'bep_unit'             => $bepUnit,
                'bep_rupiah'           => $bepRupiah,
                'status'               => $status,
                'failed_harvest_count' => $failedCount,
                'risk_harvest_count'   => $riskCount,
                'failed_harvest_loss'  => $totalLoss,
            ],
            'biaya_variabel_items' => $biayaVariabelItems,
            'total_biaya_variabel' => $totalBiayaVariabel,
            'biaya_tetap_items'    => $biayaTetapItems,
            'total_biaya_tetap'    => $totalBiayaTetap,
            'beban_fix_items'      => $bebanFixItems,
        ];
    }

}
