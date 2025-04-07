<?php

namespace App\Http\Controllers;

use App\Models\COA;
use App\Models\JenisTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class COAController extends Controller
{
    public function index()
    {
        $coa = DB::table('chart_of_accounts as coa')
        ->join('jenis_transaksi as jt', 'coa.id_jenis_transaksi', '=', 'jt.id')
        ->select('coa.*', 'jt.keterangan')
        ->get();

        $jenis_transaksi = JenisTransaksi::all();
        // dd($coa);
        return view('coa.index', compact('coa', 'jenis_transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|min:3',
            'jenis_transaksi' => 'required',
            'posisi_dr_cr' => 'required|in:d,k',
            'nama_akun' => 'required|unique:chart_of_accounts,nama_akun',
            // 'header' => 'required',
            'saldo_awal' => 'required',
        ]);

        try {
            COA::create([
                'kode_akun' => $request->kode_akun,
                'id_jenis_transaksi' => $request->jenis_transaksi,
                'nama_akun' => $request->nama_akun,
                'header' => substr($request->kode_akun, 0, 1),
                'posisi_dr_cr' => $request->posisi_dr_cr,
                'saldo_awal' => $request->saldo_awal,
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data! ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_akun' => 'required|min:3',
            'jenis_transaksi' => 'required',
            'posisi_dr_cr' => 'required|in:d,k',
            'nama_akun' => 'required|unique:chart_of_accounts,nama_akun,' . $id,
            'saldo_awal' => 'required',
        ]);

        try {
            $coa = COA::findOrFail($id);

            $coa->update([
                'kode_akun' => $request->kode_akun,
                'id_jenis_transaksi' => $request->jenis_transaksi,
                'nama_akun' => $request->nama_akun,
                'header' => substr($request->kode_akun, 0, 1),
                'posisi_dr_cr' => $request->posisi_dr_cr,
                'saldo_awal' => $request->saldo_awal,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data! ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $coa = COA::findOrFail($id);
            $coa->delete();
    
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data! ' . $e->getMessage());
        }
    }
}
