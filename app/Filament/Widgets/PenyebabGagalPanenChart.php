<?php

namespace App\Filament\Widgets;

use App\Models\Panen;
use Filament\Widgets\ChartWidget;

class PenyebabGagalPanenChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Penyebab Gagal Panen';
    protected static ?string $maxHeight = '320px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $panens = Panen::query()
            ->whereIn('status_panen', ['gagal_sebagian', 'gagal_total'])
            ->get();

        $labelsMap = [
            'hama'              => 'Hama',
            'penyakit'          => 'Penyakit Tanaman',
            'cuaca_ekstrem'     => 'Cuaca Ekstrem',
            'banjir'            => 'Banjir',
            'kekeringan'        => 'Kekeringan',
            'kesalahan_teknis'  => 'Kesalahan Teknis',
            'lainnya'           => 'Lainnya',
        ];

        $counts = array_fill_keys(array_keys($labelsMap), 0);

        foreach ($panens as $panen) {
            $cause = $panen->penyebab_gagal;

            if ($cause && array_key_exists($cause, $counts)) {
                $counts[$cause]++;
            }
        }

        $labels = array_values($labelsMap);
        $data   = [];

        foreach (array_keys($labelsMap) as $key) {
            $data[] = $counts[$key] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Gagal Panen',
                    'data'  => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}

