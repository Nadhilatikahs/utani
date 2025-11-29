<?php

namespace App\Filament\Resources\BebanTanamResource\Pages;

use App\Filament\Resources\BebanTanamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBebanTanam extends EditRecord
{
    protected static string $resource = BebanTanamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
