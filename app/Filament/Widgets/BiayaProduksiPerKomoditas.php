<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\ChartWidget;

class BiayaProduksiPerKomoditas extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan vs Biaya per Komoditas';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $tanams = Tanam::with(['komoditas', 'panens', 'bebanTanams'])->get();

        $grouped = [];

        foreach ($tanams as $tanam) {
            $nama = $tanam->komoditas->nama_komoditas ?? 'Tanpa Komoditas';

            if (! isset($grouped[$nama])) {
                $grouped[$nama] = [
                    'pendapatan' => 0,
                    'biaya'      => 0,
                    'laba'       => 0,
                ];
            }

            $grouped[$nama]['pendapatan'] += $tanam->total_pendapatan;
            $grouped[$nama]['biaya']      += $tanam->total_biaya;
            $grouped[$nama]['laba']       += $tanam->keuntungan_bersih;
        }

        $labels       = array_keys($grouped);
        $pendapatan   = array_column($grouped, 'pendapatan');
        $biaya        = array_column($grouped, 'biaya');
        $laba         = array_column($grouped, 'laba');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data'  => $pendapatan,
                ],
                [
                    'label' => 'Biaya Produksi',
                    'data'  => $biaya,
                ],
                [
                    'label' => 'Keuntungan',
                    'data'  => $laba,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
