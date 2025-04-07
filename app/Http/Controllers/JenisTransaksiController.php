<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisTransaksiController extends Controller
{
    public function index()
    {
        $jenis_transaksi = JenisTransaksi::all();
        // dd($coa);
        return view('jenis_transaksi.index', compact('jenis_transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|unique:jenis_transaksi,keterangan',
        ]);

        try {
            JenisTransaksi::create([
                'keterangan' => $request->keterangan,
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data! ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|unique:jenis_transaksi,keterangan,' . $id,
        ]);

        try {
            $jenis_transaksi = JenisTransaksi::findOrFail($id);

            $jenis_transaksi->update([
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data! ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $jenis_transaksi = JenisTransaksi::findOrFail($id);
            $jenis_transaksi->delete();
    
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data! ' . $e->getMessage());
        }
    }
}
