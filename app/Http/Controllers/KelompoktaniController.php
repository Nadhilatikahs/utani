<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use App\Models\Desa;
use App\Models\AnggotaTani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreKelompoktaniRequest;
use App\Http\Requests\UpdateKelompoktaniRequest;
use Illuminate\Support\Facades\Validator;

class KelompoktaniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompoktanis = KelompokTani::getKeltaniDetailDesa();
        $desas = Desa::orderBy('id_desa')->get(); 

         // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
        foreach ($kelompoktanis as $d) {
            $d->hasAnggotatanis = AnggotaTani::where('id_keltani', $d->id_keltani)->exists();
}
        return view('keltanis/index',compact('kelompoktanis','desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelompoktanis = Kelompoktani::all();
        $desas = Desa::all();
        return view('keltanis.create',[
            'kode_keltani' => KelompokTani::getKodekeltani(),
            'desas' => Desa::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelompoktaniRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_keltani' => 'required',
            'nama_keltani' => 'required|unique:kelompoktanis,nama_keltani',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'id_desa' => 'required',
        ]);

        // masukkan ke db
        Kelompoktani::create($request->all());
        
        return redirect()->route('keltanis.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(KelompokTani $kelompoktani)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_keltani)
    {
        $desas = Desa::all();
        $get = DB::table('kelompoktanis')->where('id_keltani', $id_keltani)->get();
        foreach ($get as $p) {
            $id_keltani = $p->id_keltani;
            $kode_keltani = $p->kode_keltani;
            $nama_keltani = $p->nama_keltani;
            $alamat = $p->alamat;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
           
        }
        return view('keltanis.edit', [
            'id_keltani' => $id_keltani,
            'kode_keltani' => $kode_keltani,
            'nama_keltani' => $nama_keltani,
            'alamat' => $alamat,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'desas' => Desa::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelompoktani $kelompoktanis)
    {
        $validated = $request->validate([
            
            'kode_keltani' => 'required',
            'nama_keltani' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
        ]);

        $update = Kelompoktani::where('id_keltani', $request->id_keltani)
            ->update([
                
                
                'kode_keltani' => $request->kode_keltani,
                'nama_keltani' => $request->nama_keltani,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
              
            ]);

        return redirect()->route('keltanis.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_keltani)
    {
        $kelompoktanis = KelompokTani::findOrFail($id_keltani);
        $kelompoktanis->delete();
        return redirect()->route('keltanis.index')->with('success', 'Data Berhasil dihapus');
    }
}
