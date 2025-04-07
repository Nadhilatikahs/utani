<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Beban;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //query data
         $kategori = Kategori::all();
          // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
        foreach ($kategori as $k) {
            $k->hasBebans = Beban::where('id_kategori', $k->id_kategori)->exists();
}
        return view('kategori/index',compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create',
        [
            'kode_kategori' => Kategori::getKodekategori()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_kategori' => 'required',
            'keterangan' => 'required',
            
        ]);

        // masukkan ke db
        Kategori::create($request->all());
        
        return redirect()->route('kategori.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_kategori)
    {
         //hapus dari database
         $kategori = Kategori::findOrFail($id_kategori);
         $kategori->delete();
 
         return redirect()->route('kategori.index')->with('success','Data Berhasil di Hapus');
    }
}
