<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenerateCode extends Model
{
    use HasFactory;

    public function generateTrxID()
    {
        $prefix = 'TRX';

        $date = Carbon::now()->format('dmY'); // Format tanggal: ddmmyyyy

        // Ambil nilai terbesar dari id_transaksi
        $lastTransaction = DB::table('transaksi') // Ganti dengan nama tabel Anda
            ->select('transaksi_id')
            ->whereNotNull('transaksi_id')
            ->where('status', '<>', 0)
            ->orderBy('transaksi_id', 'desc')
            ->first();

        // Tentukan nomor urut
        $lastNumber = $lastTransaction ? (int) substr($lastTransaction->transaksi_id, -5) : 0;
        $nextNumber = $lastNumber + 1;

        // Buat kode transaksi
        $kodeTransaksi = $prefix . $date . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return $kodeTransaksi;
    }
}
