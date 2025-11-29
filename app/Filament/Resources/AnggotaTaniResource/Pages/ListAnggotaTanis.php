<?php

namespace App\Filament\Resources\AnggotaTaniResource\Pages;

use App\Filament\Resources\AnggotaTaniResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnggotaTanis extends ListRecords
{
    protected static string $resource = AnggotaTaniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
