<?php

namespace App\Filament\Resources\BebanResource\Pages;

use App\Filament\Resources\BebanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBebans extends ListRecords
{
    protected static string $resource = BebanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
