<?php

namespace App\Filament\Resources\BebanTanamResource\Pages;

use App\Filament\Resources\BebanTanamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBebanTanams extends ListRecords
{
    protected static string $resource = BebanTanamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
