<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashTransaction;

class CashTransactionController extends Controller
{
    public function index()
    {
        $transactions = CashTransaction::all(); // Ambil semua data transaksi
        return view('cashtransactions.index', compact('transactions')); // Kirim data ke view
    }
}