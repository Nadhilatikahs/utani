<?php

namespace App\Http\Controllers;

use App\Models\Bpp;
use App\Models\Upt;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBppRequest;
use App\Http\Requests\UpdateBppRequest;
use Illuminate\Support\Facades\Validator;

class BppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bpps = Bpp::getBppDetailUpt();
        $upts = Upt::orderBy('id_upt')->get(); 
// Menambahkan informasi apakah data master memiliki data transaksi atau tidak
foreach ($bpps as $d) {
    $d->hasDesa = Desa::where('id_bpp', $d->id_bpp)->exists();
}
return view('bpps/index',compact('bpps','upts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bpps = Bpp::all();
        $upts = Upt::all();
        return view('bpps.create',[
            'kode_bpp' => Bpp::getKodebpp(),
            'upts' => Upt::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBppRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_bpp' => 'required',
            'nama_bpp' => 'required|unique:bpps,nama_bpp',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'id_upt' => 'required',
        ]);

        // masukkan ke db
        Bpp::create($request->all());
        
        return redirect()->route('bpps.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bpp $bpp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_bpp)
    {
        $upts = Upt::all();
        $get = DB::table('bpps')->where('id_bpp', $id_bpp)->get();
        foreach ($get as $p) {
            $id_bpp = $p->id_bpp;
            $kode_bpp = $p->kode_bpp;
            $nama_bpp = $p->nama_bpp;
            $alamat = $p->alamat;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
           
        }
        return view('bpps.edit', [
            'id_bpp' => $id_bpp,
            'kode_bpp' => $kode_bpp,
            'nama_bpp' => $nama_bpp,
            'alamat' => $alamat,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'upts' => Upt::all()
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bpp $bpps)
    {
        $validated = $request->validate([
            
            'kode_bpp' => 'required',
            'nama_bpp' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
        ]);

        $update = Bpp::where('id_bpp', $request->id_bpp)
            ->update([
                
                
                'kode_bpp' => $request->kode_bpp,
                'nama_bpp' => $request->nama_bpp,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
              
            ]);

        return redirect()->route('bpps.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_bpp)
    {
        $bpps = Bpp::findOrFail($id_bpp);
        $bpps->delete();
        return redirect()->route('bpps.index')->with('success', 'Data Berhasil dihapus');
    }
}
