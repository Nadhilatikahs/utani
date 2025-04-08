<?php

namespace App\Http\Controllers;

use App\Models\GenerateCode;
use App\Models\JenisTransaksi;
use App\Models\Jurnal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct() {
        $this->jurnal = new Jurnal();
    }
    public function index()
    {
        // $transactions = Transaction::all();
        $transactions = DB::select("SELECT
            a.*,
            b.keterangan as ket_detail_jenis_transaksi,
            c.keterangan as ket_jenis_transaksi
        from transaksi a
        join detail_jenis_transaksi b on b.id = a.detail_jenis_transaksi 
            and b.id_jenis_transaksi = a.jenis_transaksi
        join jenis_transaksi c on c.id = b.id_jenis_transaksi");

        $getCode = new GenerateCode();

        $kode = $getCode->generateTrxID();

        $jenis_transaksi = JenisTransaksi::all();

        return view('transactions.index', compact('transactions', 'kode', 'jenis_transaksi'));
    }

    public function getDetailTransaksi(Request $request) 
    {
        $id_jenis_transaksi = $request->id_jenis_transaksi;

        $data = DB::table('detail_jenis_transaksi')
            ->where('id_jenis_transaksi', $id_jenis_transaksi)
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'transaksi_id' => 'required',
            'tgl_transaksi' => 'required',
            'jenis_transaksi' => 'required',
            'detail_jenis_transaksi' => 'required',
            'nominal' => 'required',
        ]);

        try {
            $transaksi_id = $request->transaksi_id;
            $tgl_transaksi = $request->tgl_transaksi;
            $nominal = $request->nominal;
            $jenis_transaksi = $request->jenis_transaksi;
            $detail_jenis_transaksi = $request->detail_jenis_transaksi;

            Transaction::create([
                'transaksi_id' => $transaksi_id,
                'tgl_transaksi' => date('Y-m-d', strtotime($tgl_transaksi)),
                'total' => $nominal,
                'status' => 1,
                'jenis_transaksi' => $jenis_transaksi,
                'detail_jenis_transaksi' => $detail_jenis_transaksi,
            ]);

            $datenow = date('Y-m-d');

            /**
             * ini adalah untuk proses jurnal
             * sesuaikan untuk jurnal nya
             */

            // $this->jurnal->doJurnal($transaksi_id, $datenow, '111', $posisi, $nominal);
    
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data! ' . $e->getMessage());
        }
    }
}
