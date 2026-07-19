<?php

namespace App\Http\Controllers;

use App\Models\Beban;
use App\Models\Kategori;
use App\Models\Bebantanam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BebanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bebans   = Beban::getBebanDetailkategori();
        $kategori = Kategori::orderBy('id_kategori')->get();

        foreach ($bebans as $bb) {
            $bb->hasBebantanam = Bebantanam::where('id_beban', $bb->id_beban)->exists();
        }

        return view('bebans.index', compact('bebans', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bebans.create', [
            'kode_beban'   => Beban::getKodebeban(),
            'kategori'     => Kategori::all(),
            'kelompokList' => \App\Models\KelompokBiayaProduksi::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_beban'                 => 'required',
            'kategori'                   => 'required',
            'id_kategori'                => 'required', // old Keterangan (Beban Variabel / Beban Fix)
            'id_kelompok_biaya_produksi' => 'nullable', // new Kelompok Biaya Produksi (BBB, BTKL, BOP)
        ]);

        $idKelompok = $validated['id_kelompok_biaya_produksi'] ?? null;
        if (empty($idKelompok)) {
            $idKelompok = Beban::guessIdKelompokBiaya($validated['nama_beban'], $validated['kategori']);
        }

        $beban = Beban::create([
            'nama_beban'                 => $validated['nama_beban'],
            'kategori'                   => $validated['kategori'],
            'id_kategori'                => $validated['id_kategori'],
            'id_kelompok_biaya_produksi' => $idKelompok,
        ]);

        $beban->refresh();

        return redirect()
            ->route('bebans.index')
            ->with('success', 'Data Berhasil di Input');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_beban)
    {
        $get = DB::table('bebans')->where('id_beban', $id_beban)->first();

        if (! $get) {
            abort(404);
        }

        return view('bebans.edit', [
            'id_beban'                   => $get->id_beban,
            'kode_beban'                 => $get->kode_beban,
            'nama_beban'                 => $get->nama_beban,
            'kategori'                   => $get->kategori,
            'id_kategori'                => $get->id_kategori,
            'id_kelompok_biaya_produksi' => $get->id_kelompok_biaya_produksi,
            'bebans'                     => Beban::all(),
            'kategoriList'               => Kategori::all(),
            'kelompokList'               => \App\Models\KelompokBiayaProduksi::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beban $bebans)
    {
        $validated = $request->validate([
            'nama_beban'                 => 'required',
            'kategori'                   => 'required',
            'id_kategori'                => 'required', // old Keterangan (Beban Variabel / Beban Fix)
            'id_kelompok_biaya_produksi' => 'nullable', // new Kelompok Biaya Produksi (BBB, BTKL, BOP)
        ]);

        $idKelompok = $validated['id_kelompok_biaya_produksi'] ?? null;
        if (empty($idKelompok)) {
            $idKelompok = Beban::guessIdKelompokBiaya($validated['nama_beban'], $validated['kategori']);
        }

        Beban::where('id_beban', $request->id_beban)->update([
            'nama_beban'                 => $validated['nama_beban'],
            'kategori'                   => $validated['kategori'],
            'id_kategori'                => $validated['id_kategori'],
            'id_kelompok_biaya_produksi' => $idKelompok,
        ]);

        return redirect()
            ->route('bebans.index')
            ->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_beban)
    {
        try {
            $bebans = Beban::findOrFail($id_beban);
            $bebans->delete();

            return redirect()
                ->route('bebans.index')
                ->with('success', 'Data Berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000' || strpos($e->getMessage(), '1451') !== false) {
                return redirect()
                    ->route('bebans.index')
                    ->with('error', 'Data gagal dihapus karena sedang digunakan pada transaksi biaya tanam.');
            }
            throw $e;
        }
    }
}
