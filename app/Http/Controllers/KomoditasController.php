<?php

namespace App\Http\Controllers;

use App\Models\Komoditas;

use Illuminate\Http\Request;
use App\Http\Requests\StoreKomoditasRequest;
use App\Http\Requests\UpdateKomoditasRequest;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class KomoditasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //query data
        $komoditas = komoditas::all();
        return view('komoditas/index',
                    [
                        'komoditas' => $komoditas
                    ]
                  );
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('komoditas.create',
        [
            'kode_komoditas' => komoditas::getKodekomoditas()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_komoditas' => 'required',
            'nama_komoditas' => 'required',
            'kategori' => 'required',
            'harga_satuan' => 'required',
            
        ]);

        // masukkan ke db
        Komoditas::create($request->all());
        
        return redirect()->route('komoditas.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Komoditas $komoditas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_komoditas)
    {
        $get = DB::table('komoditas')->where('id_komoditas', $id_komoditas)->get();
        foreach ($get as $p) {
            $id_komoditas = $p->id_komoditas;
            $kode_komoditas = $p->kode_komoditas;
            $nama_komoditas = $p->nama_komoditas;
            $kategori = $p->kategori;
            $harga_satuan = $p->harga_satuan;
            
           
        }
        return view('komoditas.edit', [
            'id_komoditas' => $id_komoditas,
            'kode_komoditas' => $kode_komoditas,
            'nama_komoditas' => $nama_komoditas,
            'kategori' => $kategori,
            'harga_satuan' => $harga_satuan,
           
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komoditas $komoditas)
    {
        $validated = $request->validate([
            
            'kode_komoditas' => 'required',
            'nama_komoditas' => 'required',
            'kategori' => 'required',
            'harga_satuan' => 'required',
            
            
        ]);

        $update = Komoditas::where('id_komoditas', $request->id_komoditas)
            ->update([
                
                'kode_komoditas' => $request->kode_komoditas,
                'nama_komoditas' => $request->nama_komoditas,
                'kategori' => $request->kategori,
                'harga_satuan' => $request->harga_satuan,
                
              
            ]);

        return redirect()->route('komoditas.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_komoditas)
    {
        $komoditas = Komoditas::findOrFail($id_komoditas);
        $komoditas->delete();
        return redirect()->route('komoditas.index')->with('success', 'Data Berhasil dihapus');
    }
}
