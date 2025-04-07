<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $journal = Journal::all(); // Ambil semua jurnal dari database
        return view('journal.index', compact('journal')); // Tampilkan di view journal.index
    }

    public function create()
    {
        return view('journal.create'); // Form untuk membuat jurnal baru
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',
        ]);

        Journal::create($request->all()); // Simpan data jurnal baru

        return redirect()->route('journal.index'); // Redirect ke halaman index
    }

    public function show($id)
    {
        $journal = Journal::findOrFail($id); // Ambil jurnal berdasarkan ID
        return view('journal.show', compact('journal')); // Tampilkan detail jurnal
    }

    public function edit($id)
    {
        $journal = Journal::findOrFail($id); // Ambil jurnal untuk diedit
        return view('journal.edit', compact('journal')); // Tampilkan form edit
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',
        ]);

        $journal = Journal::findOrFail($id);
        $journal->update($request->all()); // Update data jurnal

        return redirect()->route('journal.index'); // Redirect ke halaman index
    }

    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        $journal->delete(); // Hapus jurnal

        return redirect()->route('journal.index'); // Redirect ke halaman index
    }
}
