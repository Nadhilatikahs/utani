<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ClusterKelompokTani extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Cluster Kelompok Tani';
    protected static ?string $navigationGroup = '📊 Analisis Data';
    protected static ?int    $navigationSort  = 21;

    protected static string $view = 'filament.pages.cluster-kelompok-tani';
}
