<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Dinas;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKabupatenRequest;
use App\Http\Requests\UpdateKabupatenRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // // mengambil data kabupaten dan kabupaten dari database
    	$kabupatens = Kabupaten::getKabupatenDetailProvinsi();
        $dinas = Dinas::orderBy('id_dinas')->get(); 
        
        // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
        foreach ($kabupatens as $kabupaten) {
            $kabupaten->hasDinas = Dinas::where('id_kabupaten', $kabupaten->id_kabupaten)->exists();
}
        return view('kabupatens/index',compact('kabupatens','dinas'));
        
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kabupatens = Kabupaten::all();
        $provinsis = Provinsi::all();
        return view('kabupatens.create',[
            'kode_kabupaten' => Kabupaten::getKodekabupaten(),
            'provinsis' => Provinsi::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKabupatenRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_kabupaten' => 'required',
            'nama_kabupaten' => 'required|unique:kabupatens,nama_kabupaten',
            'latitude' => 'required|unique:kabupatens,latitude',
            'longitude' => 'required|unique:kabupatens,longitude',
            'id_provinsi' => 'required'
        ]);

        // masukkan ke db
        Kabupaten::create($request->all());
        
        return redirect()->route('kabupatens.index')->with('success','Data Berhasil di Input');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Kabupaten $kabupaten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_kabupaten)
    {
        
        

        $get = DB::table('kabupatens')->where('id_kabupaten', $id_kabupaten)->get();
        foreach ($get as $p) {
            
            $id_kabupaten = $p->id_kabupaten;
            $kode_kabupaten = $p->kode_kabupaten;
            $nama_kabupaten = $p->nama_kabupaten;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
            
           
        }
        return view('kabupatens.edit', [
            
            'id_kabupaten' => $id_kabupaten,
            'kode_kabupaten' => $kode_kabupaten,
            'nama_kabupaten' => $nama_kabupaten,
            'latitude' => $latitude,
            'longitude' => $longitude,
            
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kabupaten $kabupatens)
    {
        $validated = $request->validate([
            
            'kode_kabupaten' => 'required',
            'nama_kabupaten' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
            
        ]);

        $update = Kabupaten::where('id_kabupaten', $request->id_kabupaten)
            ->update([
                
                'kode_kabupaten' => $request->kode_kabupaten,
                'nama_kabupaten' => $request->nama_kabupaten,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                
            ]);

        return redirect()->route('kabupatens.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_kabupaten)
    {
        //hapus dari database
        $kabupatens = Kabupaten::findOrFail($id_kabupaten);
        $kabupatens->delete();

        return redirect()->route('kabupatens.index')->with('success','Data Berhasil di Hapus');
   
    }
}
