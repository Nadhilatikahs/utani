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
use Illuminate\Http\Request;

class GrafikController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::count();
        $kabupatens = Kabupaten::count();
        $dinas = Dinas::count();
        $upts = Upt::count();
        $bpps = Bpp::count();
        $desas = Desa::count();
        $kelompoktanis = KelompokTani::count();
        $anggotatanis = AnggotaTani::count();
        $lahans = Lahan::count();
        $komoditas = Komoditas::count();
        $bebans = Beban::count();
        $kategori = Kategori::count();

        return view('grafik.index', compact(
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
            'kategori'
        ));
    }
    
    // Grafik pilihtahunbatang
    public function pilihtahunbatang($tahun){
        $daftartahun = Grafik::viewTahun();
        $grafik = Grafik::viewPenjualanSelectOption($tahun);
        // return $grafik;
        return view('grafik.pilihtahunbatang',
                        [
                            'grafik' => $grafik,
                            'daftartahun' => $daftartahun
                        ]
                    );
    }
    
    // viewDataPenjualanSelectOption
    public function viewDataPenjualanSelectOption($tahun){
        $grafik = Grafik::viewPenjualanSelectOption($tahun);
        return response()->json([
            'grafik'=>$grafik,
        ]);
    }
    
    // view status penjualan
    public function viewJmlPenjualan($tahun){
        $daftartahun = Grafik::viewTahun();
        $grafik = Grafik::viewJmlPenjualan($tahun);
        return view('grafik.pie',
                        [
                            'grafik' => $grafik,
                             'daftartahun' => $daftartahun
                        ]
                    );
    }
    
    public function viewJmlPenjualanJson($tahun){
        $grafik = Grafik::viewJmlPenjualan($tahun);
        return response()->json([
            'grafik'=>$grafik,
        ]);
    }
    
    // view kelompok tani
    public function viewJmlPendapatanKelompokTani($tahun){
        $daftartahun = Grafik::viewTahun();
        $grafik = Grafik::viewKelompokTani($tahun);
        return view('grafik.piekelompoktani',
                        [
                            'grafik' => $grafik,
                             'daftartahun' => $daftartahun
                        ]
                    );
    }
    
    public function viewJmlPendapatanKelompokTaniJson($tahun){
        $grafik = Grafik::viewKelompokTani($tahun);
        return response()->json([
            'grafik'=>$grafik,
        ]);
    }
    
}
