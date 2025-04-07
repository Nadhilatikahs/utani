<?php

namespace App\Http\Controllers;

use App\Models\Beban;
use App\Models\Komoditas;
use App\Models\Kategori;
use App\Models\Bebantanam;
use Illuminate\Http\Request;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBebanRequest;
use App\Http\Requests\UpdateBebanRequest;

class BebanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bebans = Beban::getBebanDetailkategori();
        $kategori = Kategori::orderBy('id_kategori')->get(); 

        // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
        foreach ($bebans as $bb) {
            $bb->hasBebantanam = Bebantanam::where('id_beban', $bb->id_beban)->exists();
            }
        return view('bebans/index',compact('bebans','kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bebans = Beban::all();
         $kategori = Kategori::all();
        return view('bebans.create',[
            'kode_beban' => Beban::getKodebeban(),
             'kategori' => Kategori::all()
        ] );
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            
            'kode_beban' => 'required',
            'nama_beban' => 'required',
            
            'kategori' => 'required',
            'id_kategori' => 'required',
           
           
        ]);

        // masukkan ke db
        Beban::create($request->all());
        
        return redirect()->route('bebans.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Beban $beban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_beban)
    {
        $bebans = Beban::all();
        $kategori = Kategori::all();
        $get = DB::table('bebans')->where('id_beban', $id_beban)->get();
        foreach ($get as $p) {
            $id_beban = $p->id_beban;
            $kode_beban = $p->kode_beban;
            $nama_beban = $p->nama_beban;
            $kategori = $p->kategori;
            $id_kategori = $p->id_kategori;
           
           
        }
        return view('bebans.edit', [
            'id_beban' => $id_beban,
            'kode_beban' => $kode_beban,
            'nama_beban' => $nama_beban,
            'kategori' => $kategori,
            'id_kategori' => $id_kategori,
            'bebans' => Beban::all(),
            'kategori' => Kategori::all()
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beban $bebans)
    {
        $validated = $request->validate([
            
            
            'kode_beban' => 'required',
            'nama_beban' => 'required',
            'kategori' => 'required',
            'id_kategori' => 'required',
           
            
        ]);

        $update = Beban::where('id_beban', $request->id_beban)
            ->update([
                
                
                'kode_beban' => $request->kode_beban,
                'nama_beban' => $request->nama_beban,
                'kategori' => $request->kategori,
                'id_kategori' => $request->id_kategori,
                
              
            ]);

        return redirect()->route('bebans.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_beban)
    {
        $bebans = Beban::findOrFail($id_beban);
        $bebans->delete();
        return redirect()->route('bebans.index')->with('success', 'Data Berhasil dihapus');
    }
}
