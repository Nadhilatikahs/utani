<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Tanam;
use App\Http\Requests\StorePanenRequest;
use App\Http\Requests\UpdatePanenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PanenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panens = Panen::getPanenDetailtanam();
    	
        $tanams = Tanam::orderBy('id_tanam')->get(); 
        

        return view('panen.index',
            [
                'panens' => $panens,
                'tanams' => $tanams
                
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $panens = Panen::all();
        $tanams = Tanam::all();
        
        return view('panen.create',[
            'kode_panen' => Panen::getKodepanen(),
            'tanams' => Tanam::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePanenRequest $request)
    {
        $validated = $request->validate([
            'kode_panen' => 'required',
            'id_tanam' => 'required',
            'tgal_panen' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
            
       
        ]);

        // masukkan ke db
        Panen::create($request->all());
        
        return redirect()->route('panen.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Panen $panen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_panen)
    {
        $get = DB::table('panens')->where('id_panen', $id_panen)->get();
        foreach ($get as $p) {
            $id_panen = $p->id_panen;
            $kode_panen = $p->kode_panen;
            
            
            $tgal_panen = $p->tgal_panen;
            $jumlah = $p->jumlah;
            $harga = $p->harga;
            
           
        }
        return view('panen.edit', [
            'id_panen' => $id_panen,
            'kode_panen' => $kode_panen,
            
            'tgal_panen' => $tgal_panen,
            'jumlah' => $jumlah,
            'harga' => $harga,
            
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panen $panen)
    {
        $validated = $request->validate([
            
            
            'id_panen'=>       'required',
            
            'kode_panen'=>       'required',
            'tgal_panen'=>       'required',
            'jumlah' => 'required',
            'harga' =>      'required',
            
            
        ]);

        $update = Panen::where('id_panen', $request->id_panen)
            ->update([
                
              
                
                'kode_panen'=>  $request->kode_panen,
                'tgal_panen'=>  $request->tgal_panen,
                'jumlah'=>  $request->jumlah,
                'harga'=>  $request->harga,
                
            ]);

        return redirect()->route('panen.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_panen)
    {
        $panens= Panen::findOrFail($id_panen);
        $panens->delete();
        return redirect()->route('panen.index')->with('success', 'Data Berhasil dihapus');
    }
}
