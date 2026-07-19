<?php

namespace App\Http\Controllers;

use App\Models\Bebantanam;
use App\Models\Tanam;
use App\Models\Beban;
use App\Http\Requests\StoreBebantanamRequest;
use App\Http\Requests\UpdateBebantanamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BebantanamController extends Controller
{
    public function index()
    {
        // Group by tanam code for simple list view
        $tanamsWithBeban = Tanam::withCount('bebantanam')
            ->has('bebantanam')
            ->orderBy('kode_tanam')
            ->get();

        return view('bebantanam.index', compact('tanamsWithBeban'));
    }

    public function create()
    {
        // FORM LAMA (single row) - tetap seperti kamu punya
        return view('bebantanam.create', [
            'kode_bebantanam' => Bebantanam::getKodebebantanam(),
            'tanams' => Tanam::all(),
            'bebans' => Beban::all(),
        ]);
    }

    public function store(StoreBebantanamRequest $request)
    {
        $validated = $request->validate([
            'kode_bebantanam' => 'required',
            'id_tanam' => 'required',
            'id_beban' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ]);

        Bebantanam::create($request->all());

        return redirect()->route('bebantanam.index')->with('success', 'Data Berhasil di Input');
    }

    public function edit($id_bebantanam)
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
            'id_bebantanam' => $id_bebantanam,
            'kode_bebantanam' => $kode_bebantanam,
            'id_tanam' => $id_tanam,
            'id_beban' => $id_beban,
            'satuan' => $satuan,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'tanams' => $tanams,
            'bebans' => $bebans,
        ]);
    }

    public function update(Request $request, Bebantanam $bebantanam)
    {
        $validated = $request->validate([
            'kode_bebantanam' => 'required',
            'id_tanam' => 'required',
            'id_beban' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ]);

        Bebantanam::where('id_bebantanam', $request->id_bebantanam)->update([
            'kode_bebantanam' => $request->kode_bebantanam,
            'id_tanam' => $request->id_tanam,
            'id_beban' => $request->id_beban,
            'satuan' => $request->satuan,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);

        return redirect()->route('bebantanam.index')->with('success', 'Data Berhasil di Update');
    }

    public function destroy(string $id_bebantanam)
    {
        $bebantanam = Bebantanam::findOrFail($id_bebantanam);
        $bebantanam->delete();

        return redirect()->route('bebantanam.index')->with('success', 'Data Berhasil dihapus');
    }

    // =========================================================
    // FITUR BARU: BATCH INPUT PER TANAM (tanpa hapus yang lama)
    // =========================================================

    public function indexByTanam($id_tanam)
    {
        $tanam = Tanam::where('id_tanam', $id_tanam)->firstOrFail();

        $items = Bebantanam::where('id_tanam', $tanam->id_tanam)
            ->with('beban')
            ->orderBy('id_bebantanam')
            ->get();

        $grandTotal = $items->sum(function ($bt) {
            $jumlah = (float) ($bt->jumlah ?? 0);
            $harga  = (float) ($bt->harga ?? 0);
            $total  = $bt->total ?? ($jumlah * $harga);
            return (float) $total;
        });

        return view('bebantanam.by_tanam', compact('tanam', 'items', 'grandTotal'));
    }

    public function createBatch($id_tanam)
    {
        $tanam  = Tanam::where('id_tanam', $id_tanam)->firstOrFail();
        $bebans = Beban::orderBy('nama_beban')->get();

        return view('bebantanam.create_batch', compact('tanam', 'bebans'));
    }

    public function storeBatch(Request $request, $id_tanam)
    {
        $tanam = Tanam::where('id_tanam', $id_tanam)->firstOrFail();

        $validated = $request->validate([
            'id_beban'      => ['required', 'array', 'min:1'],
            'id_beban.*'    => ['required', 'exists:bebans,id_beban'],
            'jumlah'        => ['required', 'array', 'min:1'],
            'jumlah.*'      => ['required', 'numeric', 'min:0.0001'],
            'satuan'        => ['required', 'array', 'min:1'],
            'satuan.*'      => ['required', 'string', 'max:30'],
            'harga'         => ['required', 'array', 'min:1'],
            'harga.*'       => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $tanam) {
            $count = count($validated['id_beban']);

            for ($i = 0; $i < $count; $i++) {
                $idBeban = $validated['id_beban'][$i] ?? null;
                $jumlah  = (float) ($validated['jumlah'][$i] ?? 0);
                $harga   = (float) ($validated['harga'][$i] ?? 0);
                $satuan  = trim((string) ($validated['satuan'][$i] ?? ''));

                if (!$idBeban || $jumlah <= 0 || $satuan === '') {
                    continue;
                }

                $data = [
                    'id_tanam' => $tanam->id_tanam,
                    'id_beban' => $idBeban,
                    'jumlah'   => $jumlah,
                    'satuan'   => $satuan,
                    'harga'    => $harga,
                    'total'    => $jumlah * $harga,
                ];

                // kalau kolom kode_bebantanam WAJIB, isi otomatis per baris
                // (kalau tabel kamu sebenarnya nullable, ini tetap aman)
                $data['kode_bebantanam'] = Bebantanam::getKodebebantanam();

                Bebantanam::create($data);
            }
        });

        return redirect()
            ->route('bebantanam.byTanam', $tanam->id_tanam)
            ->with('success', 'Transaksi beban berhasil disimpan.');
    }
}
