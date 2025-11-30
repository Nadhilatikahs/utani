<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ClusterWilayah extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Cluster Wilayah';
    protected static ?string $navigationGroup = '📊 Analisis Data';
    protected static ?int    $navigationSort  = 20;

    protected static string $view = 'filament.pages.cluster-wilayah';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
