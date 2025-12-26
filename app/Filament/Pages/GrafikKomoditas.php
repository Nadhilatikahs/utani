<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GrafikKomoditas extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Grafik Komoditas';

    protected static ?string $navigationGroup = '📊 Analisis Data';
    protected static ?int    $navigationSort  = 11;

    protected static string $view = 'filament.pages.grafik-komoditas';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

}
