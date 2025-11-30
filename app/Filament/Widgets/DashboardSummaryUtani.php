<?php

namespace App\Filament\Widgets;

use App\Models\Panen;
use App\Models\Tanam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class DashboardSummaryUtani extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards(): array
    {
        $tanams = Tanam::with(['panens', 'bebanTanams'])->get();

        $totalPanen   = (float) Panen::sum('jumlah');              // total hasil panen
        $totalTanam   = $tanams->count();                          // jumlah usaha tanam
        $totalBiaya   = $tanams->sum->total_biaya;                 // total biaya produksi
        $totalLaba    = $tanams->sum->keuntungan_bersih;           // total keuntungan
        $statusLaba   = $totalLaba >= 0 ? 'Untung' : 'Rugi';

        return [
            Card::make('Total Panen', number_format($totalPanen, 0, ',', '.'))
                ->description('Akumulasi seluruh panen')
                ->descriptionIcon('heroicon-o-sparkles'),

            Card::make('Total Tanam', number_format($totalTanam, 0, ',', '.'))
                ->description('Jumlah riwayat usaha tanam')
                ->descriptionIcon('heroicon-o-clipboard-document-check'),

            Card::make('Total Biaya Produksi', 'Rp ' . number_format($totalBiaya, 0, ',', '.'))
                ->description('Semua biaya variabel + tetap')
                ->descriptionIcon('heroicon-o-receipt-percent'),

            Card::make('Keuntungan Bersih', 'Rp ' . number_format($totalLaba, 0, ',', '.'))
                ->description($statusLaba)
                ->descriptionIcon('heroicon-o-check-badge'),
        ];
    }
}
