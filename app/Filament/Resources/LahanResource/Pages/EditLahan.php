<?php

namespace App\Filament\Resources\LahanResource\Pages;

use App\Filament\Resources\LahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLahan extends EditRecord
{
    protected static string $resource = LahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
