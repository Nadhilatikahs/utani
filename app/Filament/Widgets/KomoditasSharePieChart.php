<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\ChartWidget;

class KomoditasSharePieChart extends ChartWidget
{
    protected static ?string $heading = 'Kontribusi Komoditas (Pendapatan)';
    protected static ?string $maxHeight = '320px';

    // ⬇⬇⬇ JENIS CHART DI SINI
    protected function getType(): string
    {
        return 'pie';  // ✅ PIE CHART
    }

    protected function getData(): array
    {
        $tanams = Tanam::with(['komoditas', 'panens', 'bebanTanams'])->get();

        $pendapatanPerKomoditas = [];

        foreach ($tanams as $tanam) {
            $nama = $tanam->komoditas->nama_komoditas ?? 'Tanpa Komoditas';

            if (! isset($pendapatanPerKomoditas[$nama])) {
                $pendapatanPerKomoditas[$nama] = 0;
            }

            $pendapatanPerKomoditas[$nama] += $tanam->total_pendapatan;
        }

        $labels = array_keys($pendapatanPerKomoditas);
        $data   = array_values($pendapatanPerKomoditas);

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data'  => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
