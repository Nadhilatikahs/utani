<?php

namespace App\Http\Controllers;

use App\Models\Bebantanam;
use App\Models\Tanam;
use App\Models\Beban;
use App\Http\Requests\StoreBebantanamRequest;
use App\Http\Requests\UpdateBebantanamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BebantanamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bebantanam = DB::table('bebantanam')
        ->join('tanams', 'bebantanam.id_tanam', '=', 'tanams.id_tanam')
        ->join('bebans', 'bebantanam.id_beban', '=', 'bebans.id_beban')
        ->select('bebantanam.*', 'tanams.*', 'bebans.*')
        ->get();

        
        return view('bebantanam.index',
            (
compact('bebantanam')
        )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bebantanam = Bebantanam::all();
        $tanams = Tanam::all();
        $bebans = Beban::all();
        return view('bebantanam.create',[
            'kode_bebantanam' => Bebantanam::getKodebebantanam(),
            'tanams' => Tanam::all(),
            'bebans' => Beban::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBebantanamRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_bebantanam' => 'required',
            'id_tanam' => 'required',
            'id_beban' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
            
        ]);

        // masukkan ke db
        Bebantanam::create($request->all());
        
        return redirect()->route('bebantanam.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bebantanam $bebantanam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_bebantanam)
    {
        $tanams = Tanam::all();
        $bebans = Beban::all();
        $get = DB::table('bebantanam')->where('id_bebantanam', $id_bebantanam)->get();
        foreach ($get as $p) {
            
            $kode_bebantanam = $p->kode_bebantanam;
            $id_tanam = $p->id_tanam;
            $id_beban = $p->id_beban;
            $satuan = $p->satuan;
            $jumlah = $p->jumlah;
            $harga = $p->harga;
            
           
        }
        return view('bebantanam.edit', [
            
            'kode_bebantanam' => $kode_bebantanam,
            'id_tanam' => $id_tanam,
            'satuan' => $satuan,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'tanams' => Tanam::all(),
            'bebans' => Beban::all()
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bebantanam $bebantanam)
    {
        $validated = $request->validate([
            
            
            'kode_bebantanam'=>       'required',
            'id_tanam'=>       'required',
            'id_beban'=>       'required',
            'satuan'=>       'required',
            'jumlah' => 'required',
            'harga' =>      'required',
            
            
        ]);

        $update = Bebantanam::where('id_bebantanam', $request->id_bebantanam)
            ->update([
                
              
                'kode_bebantanam'=>  $request->kode_bebantanam,
                'id_tanam'=>  $request->id_tanam,
                'id_beban'=>  $request->id_tanam,
                'satuan'=>  $request->satuan,
                'jumlah'=>  $request->jumlah,
                'harga'=>  $request->harga,
                
            ]);

        return redirect()->route('bebantanam.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_bebantanam)
    {
        $bebantanam = Bebantanam::findOrFail($id_bebantanam);
        $bebantanam->delete();
        return redirect()->route('bebantanam.index')->with('success', 'Data Berhasil dihapus');
    }
}
