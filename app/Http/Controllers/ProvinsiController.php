<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateProvinsiRequest;
use Illuminate\Support\Facades\Validator;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //query data
        $provinsis = Provinsi::all();
        // Menambahkan informasi apakah data master memiliki data atau tidak
    foreach ($provinsis as $provinsi) {
        $provinsi->hasKabupaten = Kabupaten::where('id_provinsi', $provinsi->id_provinsi)->exists();
    }
        return view('provinsis/index',compact('provinsis'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('provinsis.create', [
        'kode_provinsi' => Provinsi::getKodeprovinsi(),
        'provinsis' => Provinsi::all(), // Ini tambahan untuk plotting label di peta
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
         // Validasi
    $validated = $request->validate([
        'kode_provinsi' => 'required|unique:provinsis,kode_provinsi',
        'nama_provinsi' => 'required|unique:provinsis,nama_provinsi',
        'latitude' => 'required|unique:provinsis,latitude',
        'longitude' => 'required|unique:provinsis,longitude',
    ]);

    
      // Jika validasi lolos, simpan data ke database
      Provinsi::create($validated);

    return redirect()->route('provinsis.index')->with('success', 'Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(  $id_provinsi)
    {
        $get = DB::table('provinsis')->where('id_provinsi', $id_provinsi)->get();
        foreach ($get as $p) {
            $id_provinsi = $p->id_provinsi;
            $kode_provinsi = $p->kode_provinsi;
            $nama_provinsi = $p->nama_provinsi;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
           
        }
        return view('provinsis.edit', [
            'id_provinsi' => $id_provinsi,
            'kode_provinsi' => $kode_provinsi,
            'nama_provinsi' => $nama_provinsi,
            'latitude' => $latitude,
            'longitude' => $longitude,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsis)
    {
        $validated = $request->validate([
            'kode_provinsi' => 'required',
            'nama_provinsi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
        ]);

        $update = Provinsi::where('id_provinsi', $request->id_provinsi)
            ->update([
                'kode_provinsi' => $request->kode_provinsi,
                'nama_provinsi' => $request->nama_provinsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
              
            ]);

        return redirect()->route('provinsis.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         //hapus dari database
         $provinsis = Provinsi::findOrFail($id);
         $provinsis->delete();
 
         return redirect()->route('provinsis.index')->with('success','Data Berhasil di Hapus');
    }
}
