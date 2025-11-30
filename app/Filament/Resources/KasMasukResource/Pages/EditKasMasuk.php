<?php

namespace App\Filament\Resources\KasMasukResource\Pages;

use App\Filament\Resources\KasMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKasMasuk extends EditRecord
{
    protected static string $resource = KasMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
