<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\ChartWidget;

class ProfitLossPerCommodityChart extends ChartWidget
{
    protected static ?string $heading = 'Keuntungan & Kerugian per Komoditas';
    protected static ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $tanams = Tanam::with(['komoditas', 'panens', 'bebanTanams'])->get();

        $labaPerKomoditas = [];

        foreach ($tanams as $tanam) {
            $nama = $tanam->komoditas->nama_komoditas ?? 'Tanpa Komoditas';

            if (! isset($labaPerKomoditas[$nama])) {
                $labaPerKomoditas[$nama] = 0;
            }

            $labaPerKomoditas[$nama] += $tanam->keuntungan_bersih;
        }

        // urutkan dari laba tertinggi ke terendah (bisa sampai negatif)
        arsort($labaPerKomoditas);

        $labels = array_keys($labaPerKomoditas);
        $data   = array_values($labaPerKomoditas);

        return [
            'datasets' => [
                [
                    'label' => 'Keuntungan (Rp)',
                    'data'  => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // bikin bar horizontal (Chart.js option)
    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
        ];
    }
}
