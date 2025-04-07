<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArusKasController extends Controller
{
    public function index()
    {
        // Mengambil total kas masuk dan kas keluar dari database
        $kasMasuk = DB::table('arus_kas')->where('type', 'masuk')->sum('amount');
        $kasKeluar = DB::table('arus_kas')->where('type', 'keluar')->sum('amount');
        $saldoKas = $kasMasuk - $kasKeluar;

        return view('aruskas', [
            'kasMasuk' => $kasMasuk,
            'kasKeluar' => $kasKeluar,
            'saldoKas' => $saldoKas
        ]);
    }

    public function create()
    {
        return view('inputKas');
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $amount = $request->input('amount');

        // Menambahkan data baru ke dalam tabel arus_kas
        DB::table('arus_kas')->insert([
            'type' => $type,
            'amount' => $amount,
            'created_at' => now(),
        ]);

        // Menambahkan jurnal otomatis berdasarkan tipe transaksi
        if ($type === 'masuk') {
            // Kas Masuk
            DB::table('journal')->insert([
                'akun' => 'Kas',
                'debit' => $amount,
                'kredit' => 0,
                'created_at' => now(),
            ]);
            DB::table('journal')->insert([
                'akun' => 'Bantuan Pemerintah',
                'debit' => 0,
                'kredit' => $amount,
                'created_at' => now(),
            ]);
        } elseif ($type === 'keluar') {
            // Kas Keluar
            DB::table('journal')->insert([
                'akun' => 'Perbaikan Lahan',
                'debit' => $amount,
                'kredit' => 0,
                'created_at' => now(),
            ]);
            DB::table('journal')->insert([
                'akun' => 'Kas',
                'debit' => 0,
                'kredit' => $amount,
                'created_at' => now(),
            ]);
        }

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->route('aruskas.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function detail($type)
    {
        if ($type === 'masuk') {
            $title = 'Detail Kas Masuk';
            $amount = DB::table('arus_kas')->where('type', 'masuk')->sum('amount');
        } elseif ($type === 'keluar') {
            $title = 'Detail Kas Keluar';
            $amount = DB::table('arus_kas')->where('type', 'keluar')->sum('amount');
        } else {
            $title = 'Detail Saldo Kas';
            $amount = DB::table('arus_kas')->where('type', 'masuk')->sum('amount') 
                      - DB::table('arus_kas')->where('type', 'keluar')->sum('amount');
        }
    
        return view('arusKasDetail', [
            'title' => $title,
            'amount' => $amount,
        ]);
    }
}
