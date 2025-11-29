<?php

namespace App\Filament\Resources\TanamResource\Pages;

use App\Filament\Resources\TanamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTanams extends ListRecords
{
    protected static string $resource = TanamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
