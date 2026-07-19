<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\ChartWidget;

class ProfitLossPerCommodityChart extends ChartWidget
{
    protected static ?string $heading = 'Keuntungan & Kerugian per Komoditas';
    protected static ?string $maxHeight = '320px';

    // ⬇⬇⬇ JENIS CHART DI SINI
    protected function getType(): string
    {
        return 'bar';  // ✅ BAR CHART
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',  // ✅ bikin bar chart jadi horizontal
        ];
    }

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
}
