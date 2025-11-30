<?php

namespace App\Filament\Resources\KasKeluarResource\Pages;

use App\Filament\Resources\KasKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKasKeluar extends EditRecord
{
    protected static string $resource = KasKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
