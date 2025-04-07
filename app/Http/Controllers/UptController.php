<?php

namespace App\Http\Controllers;

use App\Models\Upt;
use App\Models\Dinas;
use App\Models\Bpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUptRequest;
use App\Http\Requests\UpdateUptRequest;
use Illuminate\Support\Facades\Validator;

class UptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upts = Upt::getUptDetailDinas();
        $bpps = Bpp::orderBy('id_bpp')->get(); 

        // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
       foreach ($upts as $d) {
        $d->hasBpps = Bpp::where('id_upt', $d->id_upt)->exists();
}
    return view('upts/index',compact('upts','bpps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $upts = Upt::all();
        $dinas = Dinas::all();
        return view('upts.create',[
            'kode_upt' => Upt::getKodeupt(),
            'dinas' => Dinas::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUptRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_upt' => 'required',
            'nama_upt' => 'required|unique:upts,nama_upt',
            'alamat' => 'required',
            'latitude' => 'required|unique:upts,latitude',
            'longitude' => 'required|unique:upts,longitude',
            'id_dinas' => 'required',
        ]);

        // masukkan ke db
        Upt::create($request->all());
        
        return redirect()->route('upts.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Upt $upt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_upt)
    {
        $dinas = Dinas::all();
        $get = DB::table('upts')->where('id_upt', $id_upt)->get();
        foreach ($get as $p) {
            $id_upt = $p->id_upt;
            $kode_upt = $p->kode_upt;
            $nama_upt = $p->nama_upt;
            $alamat = $p->alamat;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
           
        }
        return view('upts.edit', [
            'id_upt' => $id_upt,
            'kode_upt' => $kode_upt,
            'nama_upt' => $nama_upt,
            'alamat' => $alamat,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'dinas' => Dinas::all() 

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Upt $upts)
    {
        $validated = $request->validate([
            
            'kode_upt' => 'required',
            'nama_upt' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
        ]);

        $update = Upt::where('id_upt', $request->id_upt)
            ->update([
                
                'kode_upt' => $request->kode_upt,
                'nama_upt' => $request->nama_upt,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
              
            ]);

        return redirect()->route('upts.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_upt)
    {
        $upts = Upt::findOrFail($id_upt);
        $upts->delete();
        return redirect()->route('upts.index')->with('success', 'Data Berhasil dihapus');
    }
}
