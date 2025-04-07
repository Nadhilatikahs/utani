<?php

namespace App\Http\Controllers;

use App\Models\Tanam;
use App\Models\Lahan;
use App\Models\Komoditas;
use App\Models\Bebantanam;
use App\Http\Requests\StoreTanamRequest;
use App\Http\Requests\UpdateTanamRequest;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TanamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tanams = DB::table('tanams')
        ->join('lahans', 'tanams.id_lahan', '=', 'lahans.id_lahan')
        ->join('komoditas', 'tanams.id_komoditas', '=', 'komoditas.id_komoditas')
        ->select('lahans.*', 'tanams.*', 'komoditas.*')
        ->get();

        return view('tanams.index',compact('tanams')
        );
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tanams = Tanam::all();
        $lahans = Lahan::all();
        $komoditas = Komoditas::all();
        return view('tanams.create',[
            'kode_tanam' => Tanam::getKodetanam(),
            'lahans' => Lahan::all(),
            'komoditas' => Komoditas::all()
        ] );
    }

    
   
    

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTanamRequest $request)
    {
        
        $validated = $request->validate([
            
            'kode_tanam' => 'required',
            'id_lahan' => 'required',
            'id_komoditas' => 'required',
            'tgl_tanam' => 'required',
            
        ]);

        // masukkan ke db
        Tanam::create($request->all());
        
        return redirect()->route('tanams.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tanam $tanam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_tanam)
    {   
        $get = DB::table('tanams')->where('id_tanam', $id_tanam)->get();
        foreach ($get as $p) {
           
            $id_tanam = $p->id_tanam;
            $kode_tanam = $p->kode_tanam;
            $tgl_tanam = $p->tgl_tanam;
           
           

            
           
        }
        return view('tanams.edit', [
            'id_tanam' => $id_tanam,
            'kode_tanam' => Tanam::getKodetanam(),
            'tgl_tanam' => $tgl_tanam,
          
            
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanam $tanams)
    {
        $validated = $request->validate([
            
            
            'id_tanam'=>       'required',
            'kode_tanam'=>       'nullable',
            'tgl_tanam'=>       'nullable',
            
            
            
        ]);

        $update = Tanam::where('id_tanam', $request->id_tanam)
            ->update([
                
              'id_tanam'=>  $request->id_tanam,
                'kode_tanam'=>   Tanam::getKodetanam(),
                'tgl_tanam'=>  $request->tgl_tanam,
              
                
            ]);
            // Memanggil method updateBebanVariabel untuk menghitung dan menetapkan nilai beban_variabel
    
   
            
        return redirect()->route('tanams.index')->with('success', 'Data Berhasil di Update');
    
    }
    public function updateBebanVariabel(Request $request, Tanam $tanam)
{
    $validated = $request->validate([
            
            
        'kode_tanam'=>       'nullable',
        'tgl_tanam'=>       'nullable',
       
        
        
    ]);

    $update = Tanam::where('id_tanam', $request->id_tanam)
        ->update([
            
          
            'kode_tanam'=>  $request->kode_tanam,
            'tgl_tanam'=>  $request->tgl_tanam,
           
            
        ]);
    $tanam->updateBebanVariabel();
    return redirect()->route('tanams.index')->with('success', 'Data Berhasil di Update');

    return response()->json(['message' => 'Beban variabel berhasil diperbarui.']);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_tanam)
    {
        $tanams = Tanam::findOrFail($id_tanam);
        $tanams->delete();
        return redirect()->route('tanams.index')->with('success', 'Data Berhasil dihapus');
    }
}
