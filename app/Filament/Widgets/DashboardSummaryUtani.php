<?php

namespace App\Filament\Widgets;

use App\Models\Panen;
use App\Models\Tanam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class DashboardSummaryUtani extends BaseWidget
{
    protected static ?string $heading = 'Ringkasan Usaha Tani';

    protected function getCards(): array
    {
        $tanams = Tanam::with(['panens', 'bebanTanams'])->get();
        $panens = Panen::all();

        $totalPanenKg   = (float) Panen::sum('jumlah');
        $totalTanam     = $tanams->count();
        $totalBiaya     = $tanams->sum->total_biaya;
        $totalLaba      = $tanams->sum->keuntungan_bersih;

        // Statistik gagal panen (level transaksi panen)
        $totalPanenTrans   = $panens->count();
        $totalGagalPanen   = $panens->whereIn('status_panen', ['gagal_sebagian', 'gagal_total'])->count();
        $persenGagalPanen  = $totalPanenTrans > 0
            ? round(($totalGagalPanen / $totalPanenTrans) * 100, 2)
            : 0.0;

        // Statistik risiko (level musim tanam)
        $tanamDenganGagal = $tanams->filter(function (Tanam $tanam) {
            return $tanam->panens
                ->whereIn('status_panen', ['gagal_sebagian', 'gagal_total'])
                ->isNotEmpty();
        });

        $totalTanamBerisiko = $tanamDenganGagal->count();
        $tingkatRisiko      = $totalTanam > 0
            ? round(($totalTanamBerisiko / $totalTanam) * 100, 2)
            : 0.0;

        // Total kerugian akibat gagal panen:
        // pendekatan: untuk setiap tanam yang punya gagal panen,
        //             kerugian = max(0, total_biaya - total_pendapatan)
        $totalKerugianGagal = $tanamDenganGagal->sum(function (Tanam $tanam) {
            $pendapatan = $tanam->total_pendapatan;
            $biaya      = $tanam->total_biaya;

            return max(0, $biaya - $pendapatan);
        });

        $statusLaba = $totalLaba >= 0 ? 'Untung' : 'Rugi';

        return [
            Card::make('Total Panen (Kg)', number_format($totalPanenKg, 0, ',', '.'))
                ->description('Akumulasi seluruh panen'),

            Card::make('Total Tanam', number_format($totalTanam, 0, ',', '.'))
                ->description('Total musim tanam yang tercatat'),

            Card::make('Total Biaya Produksi', 'Rp ' . number_format($totalBiaya, 0, ',', '.'))
                ->description('Biaya variabel + tetap (semua tanam)'),

            Card::make('Keuntungan Bersih', 'Rp ' . number_format($totalLaba, 0, ',', '.'))
                ->description("Status: {$statusLaba}"),

            Card::make('Gagal Panen', "{$totalGagalPanen} dari {$totalPanenTrans} panen")
                ->description('Persentase gagal: ' . number_format($persenGagalPanen, 2, ',', '.') . ' %'),

            Card::make('Tingkat Risiko Usaha', number_format($tingkatRisiko, 2, ',', '.') . ' %')
                ->description("Tanam berisiko: {$totalTanamBerisiko} dari {$totalTanam} musim tanam"),

            Card::make('Kerugian Akibat Gagal Panen', 'Rp ' . number_format($totalKerugianGagal, 0, ',', '.'))
                ->description('Perkiraan selisih biaya - pendapatan pada musim yang mengalami gagal panen'),
        ];
    }
}
