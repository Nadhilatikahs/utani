<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class OverviewBiayaProduksi extends BaseWidget
{
    protected static ?string $pollingInterval = null; // tidak auto refresh

    protected function getCards(): array
    {
        $tanams = Tanam::with(['panens', 'bebanTanams'])->get();

        $totalPendapatan = $tanams->sum->total_pendapatan;
        $totalBiaya      = $tanams->sum->total_biaya;
        $totalLaba       = $tanams->sum->keuntungan_bersih;
        $totalTanam      = $tanams->count();

        return [
            Card::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description("Dari {$totalTanam} usaha tanam")
                ->descriptionIcon('heroicon-o-banknotes'),

            Card::make('Total Biaya Produksi', 'Rp ' . number_format($totalBiaya, 0, ',', '.'))
                ->description('BBB + BTKL + BOP + Biaya Tetap')
                ->descriptionIcon('heroicon-o-receipt-percent'),

            Card::make('Total Keuntungan Bersih', 'Rp ' . number_format($totalLaba, 0, ',', '.'))
                ->description($totalLaba >= 0 ? 'Usaha dalam kondisi untung' : 'Usaha dalam kondisi rugi')
                ->descriptionIcon('heroicon-o-chart-bar'),
        ];
    }
}
