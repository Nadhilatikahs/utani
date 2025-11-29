<?php

namespace App\Filament\Resources\PanenResource\Pages;

use App\Filament\Resources\PanenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPanen extends EditRecord
{
    protected static string $resource = PanenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
