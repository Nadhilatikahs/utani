<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\AnggotaTani;
use App\Models\Tanam;
use App\Http\Requests\StoreLahanRequest;
use App\Http\Requests\UpdateLahanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
class LahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lahans = Lahan::getLahanDetailanggota();
        $anggotatanis = AnggotaTani::orderBy('id_anggota')->get();

        // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
        foreach ($lahans as $lh) {
            $lh->hasTanams = Tanam::where('id_lahan', $lh->id_lahan)->exists();
}
        return view('lahans/index',compact('lahans','anggotatanis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lahans = Lahan::all();
        $anggotatanis = AnggotaTani::all();
        return view('lahans.create',[
            'kode_lahan' => Lahan::getKodelahan(),
            'anggotatanis' => AnggotaTani::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLahanRequest $request)
    {
        $validated = $request->validate([

            'kode_lahan' => 'required',
            'id_anggota' => 'required',
            'luas' => 'required',
            'jml_petak' => 'required',

        ]);

        // masukkan ke db
        Lahan::create($request->all());

        return redirect()->route('lahans.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lahan $lahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_lahan)
    {
        $anggotatanis = AnggotaTani::all();
        $get = DB::table('lahans')->where('id_lahan', $id_lahan)->get();
        foreach ($get as $p) {

            $id_lahan = $p->id_lahan;
            $kode_lahan = $p->kode_lahan;
            $id_anggota = $p->id_anggota;
            $luas = $p->luas;
            $jml_petak = $p->jml_petak;


        }
        return view('lahans.edit', [

            'id_lahan' => $id_lahan,
            'kode_lahan' => $kode_lahan,
            'id_anggota' => $id_anggota,
            'luas' => $luas,
            'jml_petak' => $jml_petak,
            'anggotatanis' => AnggotaTani::all()

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lahan $lahans)
    {
        $validated = $request->validate([


            'kode_lahan' => 'required',
            'id_anggota' => 'required',
            'luas' => 'required',
            'jml_petak' => 'required',



        ]);

        $update = Lahan::where('id_lahan', $request->id_lahan)
            ->update([


                'kode_lahan' => $request->kode_lahan,
                'id_anggota' => $request->id_anggota,
                'luas' => $request->luas,
                'jml_petak' => $request->jml_petak



            ]);

        return redirect()->route('lahans.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_lahan)
    {
        $lahans = Lahan::findOrFail($id_lahan);
        $lahans->delete();
        return redirect()->route('lahans.index')->with('success', 'Data Berhasil dihapus');
    }
}
