<?php

namespace App\Http\Controllers;

use App\Models\Bebanfix;
use App\Http\Requests\StoreBebanfixRequest;
use App\Http\Requests\UpdateBebanfixRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class BebanfixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bebanfixes = Bebanfix::all();
         

        return view('bebanfix.index',
            [
                'bebanfixes' => $bebanfixes,
                
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bebanfixes = Bebanfix::all();
        
        return view('bebanfix.create',[
            'kode_beban_fix' => Bebanfix::getKodebebanfix(),
            
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBebanfixRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'id_bebanfix' => 'required',
            'kode_beban_fix' => 'required',
            'keterangan' => 'required',
            
            'nominal' => 'required',
           
           
        ]);

        // masukkan ke db
        Bebanfix::create($request->all());
        
        return redirect()->route('bebanfix.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bebanfix $bebanfix)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bebanfix $bebanfix)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBebanfixRequest $request, Bebanfix $bebanfix)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bebanfix $bebanfix)
    {
        //
    }
}
