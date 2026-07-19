<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Tanam;
use App\Http\Requests\StorePanenRequest;
use App\Http\Requests\UpdatePanenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            'kode_panen'    => 'required',
            'id_tanam'      => 'required',
            'tgal_panen'    => 'required|date',
            'jumlah'        => 'required|numeric|min:0',
            'harga'         => 'required|numeric|min:0',
            'status_panen'  => ['required', Rule::in(['berhasil', 'gagal_sebagian', 'gagal_total'])],
            'penyebab_gagal'=> 'nullable|required_unless:status_panen,berhasil',
            'keterangan'    => 'nullable|string',
        ]);

        // Business rule: jika gagal total, jumlah tidak boleh > 0
        if ($validated['status_panen'] === 'gagal_total' && (float) ($validated['jumlah'] ?? 0) > 0) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah harus 0 untuk panen dengan status Gagal Total.'])
                ->withInput();
        }

        // masukkan ke db (model boot() akan menghitung hasil_panen & enforce rules)
        Panen::create($validated);
        
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
            $id_panen = $p->id_panen ?? null;
            $kode_panen = $p->kode_panen ?? null;
            
            
            $tgal_panen = $p->tgal_panen ?? null;
            $jumlah = $p->jumlah ?? null;
            $harga = $p->harga ?? null;
            $status_panen   = $p->status_panen ?? 'berhasil';
            $penyebab_gagal = $p->penyebab_gagal ?? null;
            $keterangan     = $p->keterangan ?? null;
            
           
        }
        return view('panen.edit', [
            'id_panen' => $id_panen,
            'kode_panen' => $kode_panen,
            
            'tgal_panen' => $tgal_panen,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'status_panen'   => $status_panen,
            'penyebab_gagal' => $penyebab_gagal,
            'keterangan'     => $keterangan,
            
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panen $panen)
    {
        $validated = $request->validate([
            'id_panen'      => 'required',
            'kode_panen'    => 'required',
            'tgal_panen'    => 'required|date',
            'jumlah'        => 'required|numeric|min:0',
            'harga'         => 'required|numeric|min:0',
            'status_panen'  => ['required', Rule::in(['berhasil', 'gagal_sebagian', 'gagal_total'])],
            'penyebab_gagal'=> 'nullable|required_unless:status_panen,berhasil',
            'keterangan'    => 'nullable|string',
        ]);

        if ($validated['status_panen'] === 'gagal_total' && (float) ($validated['jumlah'] ?? 0) > 0) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah harus 0 untuk panen dengan status Gagal Total.'])
                ->withInput();
        }

        $panenModel = Panen::findOrFail($validated['id_panen']);
        $panenModel->update([
            'kode_panen'     => $validated['kode_panen'],
            'tgal_panen'     => $validated['tgal_panen'],
            'jumlah'         => $validated['jumlah'],
            'harga'          => $validated['harga'],
            'status_panen'   => $validated['status_panen'],
            'penyebab_gagal' => $validated['penyebab_gagal'] ?? null,
            'keterangan'     => $validated['keterangan'] ?? null,
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
