<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GrafikKelompokTani extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Grafik Kelompok Tani';
    protected static ?string $navigationGroup = '📊 Analisis Data';
    protected static ?int    $navigationSort  = 12;

    protected static string $view = 'filament.pages.grafik-kelompok-tani';
}
