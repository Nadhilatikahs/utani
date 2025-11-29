<?php

namespace App\Filament\Resources\AnggotaTaniResource\Pages;

use App\Filament\Resources\AnggotaTaniResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnggotaTani extends EditRecord
{
    protected static string $resource = AnggotaTaniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
