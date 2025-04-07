<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Bpp;
use App\Models\KelompokTani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDesaRequest;
use App\Http\Requests\UpdateDesaRequest;
use Illuminate\Support\Facades\Validator;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desas = Desa::getDesaDetailBpp();
        $bpps = Bpp::orderBy('id_bpp')->get(); 

       // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
foreach ($desas as $d) {
    $d->hasKelompoktanis = KelompokTani::where('id_desa', $d->id_desa)->exists();
}
return view('desas/index',compact('desas','bpps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::all();
        $bpps = Bpp::all();
        return view('desas.create',[
            'kode_desa' => Desa::getKodedesa(),
            'bpps' => Bpp::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesaRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_desa' => 'required',
            'nama_desa' => 'required|unique:desas,nama_desa',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'id_bpp' => 'required',
        ]);

        // masukkan ke db
        Desa::create($request->all());
        
        return redirect()->route('desas.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_desa)
    {
        $bpps = Bpp::all();
        $get = DB::table('desas')->where('id_desa', $id_desa)->get();
        foreach ($get as $p) {
            $id_desa = $p->id_desa;
            $kode_desa = $p->kode_desa;
            $nama_desa = $p->nama_desa;
            $alamat = $p->alamat;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
           
        }
        return view('desas.edit', [
            'id_desa' => $id_desa,
            'kode_desa' => $kode_desa,
            'nama_desa' => $nama_desa,
            'alamat' => $alamat,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'bpps' => Bpp::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desa $desas)
    {
        $validated = $request->validate([
            
            'kode_desa' => 'required',
            'nama_desa' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
        ]);

        $update = Desa::where('id_desa', $request->id_desa)
            ->update([
                
                
                'kode_desa' => $request->kode_desa,
                'nama_desa' => $request->nama_desa,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
              
            ]);

        return redirect()->route('desas.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_desa)
    {
        $desas = Desa::findOrFail($id_desa);
        $desas->delete();
        return redirect()->route('desas.index')->with('success', 'Data Berhasil dihapus');
    }
}
