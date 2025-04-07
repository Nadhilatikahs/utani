<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();   
        return view('transactions.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'transaksi_id' => 'required',
            'tgl_transaksi' => 'required',
            'nominal' => 'required',
            // 'account_id' => 'required|integer'
        ]);

        Transaction::create([
            // kiri : nama kolom -> kanan : attribute dari form/view 
            'transaksi_id' => $request->transaksi_id,
            'tgl_transaksi' => $request->tgl_transaksi,
            'total' => $request->nominal,
        ]);

        // return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');

        return redirect()->to('transaksi');
    }
}
