<?php

namespace App\Filament\Widgets;

use App\Models\Tanam;
use Filament\Widgets\ChartWidget;

class ProfitLossPerMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Keuntungan / Kerugian per Bulan';
    protected static ?string $maxHeight = '320px';

    // ⬇⬇⬇ JENIS CHART DI SINI
    protected function getType(): string
    {
        return 'line';  // ✅ LINE CHART
    }

    protected function getFilters(): array
    {
        $years = Tanam::whereNotNull('tgl_panen')
            ->selectRaw('YEAR(tgl_panen) as year')
            ->distinct()
            ->pluck('year')
            ->sortDesc();

        if ($years->isEmpty()) {
            $years = collect([now()->year]);
        }

        return $years->mapWithKeys(fn ($y) => [$y => (string) $y])->toArray();
    }

    protected function getData(): array
    {
        $year = $this->filter ?? now()->year;

        $tanams = Tanam::with(['panens', 'bebanTanams'])
            ->whereYear('tgl_panen', $year)
            ->get();

        $labaPerBulan = array_fill(1, 12, 0.0);

        foreach ($tanams as $tanam) {
            $month = $tanam->tgl_panen?->format('n');
            if (! $month) {
                continue;
            }

            $labaPerBulan[$month] += $tanam->keuntungan_bersih;
        }

        $labels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des',
        ];

        return [
            'datasets' => [
                [
                    'label' => "Keuntungan {$year}",
                    'data'  => array_values($labaPerBulan),
                ],
            ],
            'labels' => $labels,
        ];
    }
}
