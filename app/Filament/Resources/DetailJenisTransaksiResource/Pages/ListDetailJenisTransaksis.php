<?php

namespace App\Filament\Resources\DetailJenisTransaksiResource\Pages;

use App\Filament\Resources\DetailJenisTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailJenisTransaksis extends ListRecords
{
    protected static string $resource = DetailJenisTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
