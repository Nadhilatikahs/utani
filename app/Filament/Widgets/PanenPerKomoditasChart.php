<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\ChartWidget;

class PanenPerKomoditasChart extends ChartWidget
{
    protected static ?string $heading = 'Hasil Panen per Komoditas';
    protected static ?string $maxHeight = '320px';

    // ⬇⬇⬇ JENIS CHART DI SINI
    protected function getType(): string
    {
        return 'bar';  // ✅ BAR CHART
    }

    protected function getData(): array
    {
        $tanams = Tanam::with(['komoditas', 'panens'])->get();

        $panenPerKomoditas = [];

        foreach ($tanams as $tanam) {
            $nama = $tanam->komoditas->nama_komoditas ?? 'Tanpa Komoditas';

            if (! isset($panenPerKomoditas[$nama])) {
                $panenPerKomoditas[$nama] = 0;
            }

            $panenPerKomoditas[$nama] += (float) $tanam->panens->sum('jumlah');
        }

        $labels = array_keys($panenPerKomoditas);
        $data   = array_values($panenPerKomoditas);

        return [
            'datasets' => [
                [
                    'label' => 'Total Panen',
                    'data'  => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
