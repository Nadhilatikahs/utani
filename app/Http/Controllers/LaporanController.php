<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Beban;
use App\Models\Bebantanam;
use App\Models\Tanam;
use App\Models\Panen;
use App\Models\Komoditas;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )
    {

        

            // Mengambil parameter filter jika ada
            $filter = $request->input('filter_id_tanam', '');

            // Query dasar dari tabel bebantanam
            $query = DB::table('bebantanam')
                ->join('bebans', 'bebantanam.id_beban', '=', 'bebans.id_beban')
                ->join('tanams', 'bebantanam.id_tanam', '=', 'tanams.id_tanam')
                ->select('bebantanam.*', 'bebans.nama_beban', 'bebans.kategori','tanams.*');
    
            // Menambahkan filter berdasarkan id_tanam jika ada
            if (!empty($filter)) {
                $query->where('bebantanam.id_tanam', $filter);
            }
    
            // Mengurutkan data berdasarkan id_tanam
            $data = $query->orderBy('bebantanam.id_tanam')->get();
    
            // Jika data kosong, tambahkan pesan debug
            if ($data->isEmpty()) {
                // Berikan pesan kosong jika data tidak ada
                $dataKosong = true;
            } else {
                $dataKosong = false;
            }

             // Mengambil daftar kode_tanam untuk digunakan dalam dropdown
             $kodeTanamList = DB::table('tanams')
             ->join('bebantanam', 'tanams.id_tanam', '=', 'bebantanam.id_tanam')
             ->select('tanams.kode_tanam', 'tanams.id_tanam')
             ->distinct()
             ->pluck('tanams.kode_tanam', 'bebantanam.id_tanam');
    
            // Ambil semua data dari tabel komoditas dan beban dengan filter id_tanam
          

          

            
    
            return view('laporan.index', compact('data', 'filter', 'dataKosong','kodeTanamList'));
    
     
}
        /*
        $cacah_pengeluaran=0; //bibit
        foreach ($data as $judul => $kategori){
            echo  $cacah_pengeluaran."<br>";
            echo "<pre>";            
            print_r($judul);
            echo "</pre>";
            foreach ($kategori as $sub_judul => $isi){
                echo "<pre>";  
                print_r($sub_judul);
                echo "</pre>";
                foreach ($isi as $index => $item){
                    // echo "***";
                    echo "<pre>";  
                    // print_r($item);
                    if($cacah_pengeluaran==1){
                        echo "nama beban = ".$item->nama_beban;
                        echo $item->kategori."-".$item->harga."-" .$item->satuan."-".$item->total."<br>";
                    }elseif($cacah_pengeluaran==0){
                        echo "nama komoditas = ".$item->nama_komoditas;
                    }
                    
                    echo "</pre>";
                }
                $cacah_pengeluaran=$cacah_pengeluaran+1;

            }
           
        }
        */

        //  $data = [
        //      "A. Pengeluaran" => [
        //          "1. Bibit " => $komoditas,
        //          "2. Persiapan lahan " => $bebans = DB::table('bebans')
        //                 ->join('bebantanam', 'bebans.id_beban', '=','bebantanam.id_bebantanam')
        //                 ->select('bebans.*','bebantanam.harga')
        //                 ->get(),
                 
        //          "3. Pemupukan " => $bebans = Beban::orderby('kategori', 'asc')->where('kategori', 'Pajak')->get()
        //      ],
        //      "B. Pendapatan" => [],
        //      "C. Keuntungan" => []
        //  ];
        
         // Kirim data ke view
       

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
    // Mengambil parameter filter jika ada
    $filter = $request->input('filter_id_tanam', '');

    // Query dasar dari tabel bebantanam
    $query = DB::table('bebantanam')
        ->join('bebans', 'bebantanam.id_beban', '=', 'bebans.id_beban')
        ->join('tanams', 'tanams.id_tanam', '=', 'bebantanam.id_tanam')
        ->select('bebantanam.*', 'bebans.nama_beban', 'bebans.kategori','tanams.kode_tanam');

    // Menambahkan filter berdasarkan id_tanam jika ada
    if (!empty($filter)) {
        $query->where('bebantanam.id_tanam', $filter);
    }

    // Mengurutkan data berdasarkan id_tanam
    $data = $query->orderBy('bebantanam.id_tanam')->get();

    // Jika data kosong, tambahkan pesan debug
    if ($data->isEmpty()) {
        // Berikan pesan kosong jika data tidak ada
        $dataKosong = true;
    } else {
        $dataKosong = false;
    }
     // Mengambil daftar kode_tanam untuk digunakan dalam dropdown
     $kodeTanamList = DB::table('tanams')
     ->join('bebantanam', 'tanams.id_tanam', '=', 'bebantanam.id_tanam')
     ->select('tanams.kode_tanam', 'tanams.id_tanam')
     ->distinct()
     ->pluck('tanams.kode_tanam', 'bebantanam.id_tanam');


    // Ambil semua data dari tabel komoditas dan beban dengan filter id_tanam
    $komoditas = DB::table('tanams')
    ->join('komoditas', 'tanams.id_komoditas', '=', 'komoditas.id_komoditas')
    ->select('komoditas.*', 'tanams.*')
    ->when($filter, function ($query, $filter) {
        return $query->where('tanams.id_tanam', $filter);
    })
    ->orderBy('tanams.id_tanam')
    ->get();

    
    $bebans_persiapan_lahan = DB::table('bebans')
        ->join('bebantanam', 'bebans.id_beban', '=', 'bebantanam.id_beban')
        ->where('bebans.kategori', 'Persiapan lahan')
        ->select('bebans.*', 'bebantanam.*')
        ->when($filter, function ($query, $filter) {
            return $query->where('bebantanam.id_tanam', $filter);
        })
        ->orderBy('bebantanam.id_tanam')
        ->get();

    $bebans_pemupukan = DB::table('bebans')
        ->join('bebantanam', 'bebans.id_beban', '=', 'bebantanam.id_beban')
        ->where('bebans.kategori', 'Pemupukan')
        ->select('bebans.*', 'bebantanam.*')
        ->when($filter, function ($query, $filter) {
            return $query->where('bebantanam.id_tanam', $filter);
        })
        ->orderBy('bebantanam.id_tanam')
        ->get();

    $bebans_pemeliharaan = DB::table('bebans')
        ->join('bebantanam', 'bebans.id_beban', '=', 'bebantanam.id_beban')
        ->where('bebans.kategori', 'Pemeliharaan')
        ->select('bebans.*', 'bebantanam.*')
        ->when($filter, function ($query, $filter) {
            return $query->where('bebantanam.id_tanam', $filter);
        })
        ->orderBy('bebantanam.id_tanam')
        ->get();


    $bebans_panen_pasca_panen = DB::table('bebans')
        ->join('bebantanam', 'bebans.id_beban', '=', 'bebantanam.id_beban')
        ->where('bebans.kategori', 'Pasca Panen')
        ->select('bebans.*', 'bebantanam.*')
        ->when($filter, function ($query, $filter) {
            return $query->where('bebantanam.id_tanam', $filter);
        })
        ->orderBy('bebantanam.id_tanam')
        ->get();
    $bebans_pajak = DB::table('bebans')
        ->join('bebantanam', 'bebans.id_beban', '=', 'bebantanam.id_beban')
        ->where('bebans.kategori', 'pajak')
        ->select('bebans.*', 'bebantanam.*')
        ->when($filter, function ($query, $filter) {
            return $query->where('bebantanam.id_tanam', $filter);
        })
        ->orderBy('bebantanam.id_tanam')
        ->get();
        
    
    // Mengambil semua record dan mengelompokkan berdasarkan id_tanam
    $jumlahTotalPerId = DB::table('bebantanam')
    ->selectRaw('SUM(total) as jumlah_total')
    ->groupBy('id_tanam')
    ->when($filter, function ($query, $filter) {
        return $query->where('bebantanam.id_tanam', $filter);
    })
    ->get();

// komponen pendapatan
$hasil_panen = DB::table('panens')
->join('tanams', 'tanams.id_tanam', '=', 'panens.id_tanam')
->select('panens.*','tanams.*')
->when($filter, function ($query, $filter) {
    return $query->where('panens.id_tanam', $filter);
})
->orderBy('panens.id_tanam')
->get();


$jumlahTotalpanen = DB::table('panens')
->selectRaw('SUM(hasil_panen) as total_panen')
->groupBy('id_tanam')
->when($filter, function ($query, $filter) {
    return $query->where('panens.id_tanam', $filter);
})
->get();


$keuntungan = DB::table('tanams')
->select('tanams.*')
->when($filter, function ($query, $filter) {
    return $query->where('tanams.id_tanam', $filter);
})
->orderBy('tanams.id_tanam')
->get();

    // Struktur data yang akan dikirim ke view
    $data = [
        'A. Komponen Pengeluaran' => [
            '1. Bibit ' => $komoditas,
            '2. Persiapan lahan ' => $bebans_persiapan_lahan,
            '3. Pemupukan ' => $bebans_pemupukan,
            '4. Pemeliharaan ' => $bebans_pemeliharaan,
            '5. Panen dan Pasca Panen ' => $bebans_panen_pasca_panen,
            '6. Pajak ' => $bebans_pajak,
            'Jumlah Total Pengeluaran' => $jumlahTotalPerId,
            
           
        ],
        
        'B. Komponen Pendapatan' =>[
            '1. Hasil Panen' => $hasil_panen,
            'Jumlah Total Pendapatan' => $jumlahTotalpanen

        ],
        'C. Komponen Keuntungan'=> [
            '1. Keuntungan' => $keuntungan,

        ],
    ];
    //  dd($hasil_panen);

    return view('laporan.show', compact('data', 'filter', 'dataKosong', 'kodeTanamList'));

    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        //
    }
}
