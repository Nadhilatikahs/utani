<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisTransaksi;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $detail_transaksi = DB::table('detail_jenis_transaksi')
            ->selectRaw("
                detail_jenis_transaksi.*,
                jenis_transaksi.keterangan as ket_jenis_transaksi
            ")
            ->join("jenis_transaksi", "detail_jenis_transaksi.id_jenis_transaksi", "=", "jenis_transaksi.id")
            ->get();

        $jenis_transaksi = JenisTransaksi::all();
        return view('detail_jenis_transaksi.index', compact('jenis_transaksi', 'detail_transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi' => 'required',
            'keterangan' => 'required|unique:detail_jenis_transaksi,keterangan',
        ]);

        try {
            DB::table('detail_jenis_transaksi')
                ->insert([
                    'id_jenis_transaksi' => $request->jenis_transaksi,
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
            'jenis_transaksi' => 'required',
            'keterangan' => 'required|unique:detail_jenis_transaksi,keterangan,' . $id,
        ]);

        try {
            // $jenis_transaksi = JenisTransaksi::findOrFail($id);

            // $jenis_transaksi->update([
            //     'keterangan' => $request->keterangan,
            // ]);

            DB::table('detail_jenis_transaksi')
                ->where('id', $id)
                ->update([
                    'id_jenis_transaksi' => $request->jenis_transaksi,
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
            // $jenis_transaksi = JenisTransaksi::findOrFail($id);
            // $jenis_transaksi->delete();

            DB::table('detail_jenis_transaksi')
                ->where('id', $id)
                ->delete();
    
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data! ' . $e->getMessage());
        }
    }
}
