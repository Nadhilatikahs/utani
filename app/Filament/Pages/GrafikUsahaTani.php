<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GrafikUsahaTani extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Grafik Usaha Tani';
    protected static ?string $navigationGroup = '📊 Analisis Data';
    protected static ?int    $navigationSort  = 10;

    protected static string $view = 'filament.pages.grafik-usaha-tani';

    public static function shouldRegisterNavigation(): bool
    {
        // jangan tampil di sidebar
        return false;
    }
}
