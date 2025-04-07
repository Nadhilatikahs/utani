<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use App\Models\GeneralJournal;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $cashTransactions = CashTransaction::all();
        $journals = GeneralJournal::all();

        return view('reports.index', compact('cashTransactions', 'journals'));
    }
}