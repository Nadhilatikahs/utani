<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ClusterBiayaPertanian extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Cluster Biaya Pertanian';
    protected static ?string $navigationGroup = '📊 Analisis Data';
    protected static ?int    $navigationSort  = 22;

    protected static string $view = 'filament.pages.cluster-biaya-pertanian';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
