<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Upt;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDinasRequest;
use App\Http\Requests\UpdateDinasRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // // mengambil data kabupaten dan kabupaten dari database
    	$dinas = Dinas::getDinasDetailKabupaten();
        $upts = Upt::orderBy('id_upt')->get(); 

       // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
       foreach ($dinas as $d) {
        $d->hasUpts = Upt::where('id_dinas', $d->id_dinas)->exists();
}
    return view('dinas/index',compact('upts','dinas'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $dinas = Dinas::all(); // Ambil semua data dinas (termasuk lat/long)
    $kabupatens = Kabupaten::all();

    return view('dinas.create', [
        'kode_dinas' => Dinas::getKodedinas(),
        'kabupatens' => $kabupatens,
        'lokasis' => $dinas // Kirim ke view untuk plotting marker
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDinasRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_dinas' => 'required|unique:dinas,kode_dinas',
            'nama_dinas' => 'required|unique:dinas,nama_dinas',
            'alamat' => 'required',
            'latitude' => 'required|unique:dinas,latitude',
            'longitude' => 'required|unique:dinas,longitude',
            'id_kabupaten' => 'required',
        ]);

        // masukkan ke db
        Dinas::create($request->all());
        
        return redirect()->route('dinas.index')->with('success','Data Berhasil di Input');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Dinas $dinas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_dinas)
    {
        
        $get = DB::table('dinas')->where('id_dinas', $id_dinas)->get();
        foreach ($get as $p) {
            $id_dinas = $p->id_dinas;
            $kode_dinas = $p->kode_dinas;
            $nama_dinas = $p->nama_dinas;
            $alamat = $p->alamat;
            $latitude = $p->latitude;
            $longitude = $p->longitude;

           
        }
        return view('dinas.edit', [
            'id_dinas' => $id_dinas,
            'kode_dinas' => $kode_dinas,
            'nama_dinas' => $nama_dinas,
            'alamat' => $alamat,
            'latitude' => $latitude,
            'longitude' => $longitude,
            
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dinas $dinas)
    {
        $validated = $request->validate([
            
            'kode_dinas' => 'required',
            'nama_dinas' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            
        ]);

        $update = Dinas::where('id_dinas', $request->id_dinas)
            ->update([
                
                'kode_dinas' => $request->kode_dinas,
                'nama_dinas' => $request->nama_dinas,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
              
            ]);

        return redirect()->route('dinas.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_dinas)
    {
        $dinas = Dinas::findOrFail($id_dinas);
        $dinas->delete();
        return redirect()->route('dinas.index')->with('success', 'Data Berhasil dihapus');
    }
}
