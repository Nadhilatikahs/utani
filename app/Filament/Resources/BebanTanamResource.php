<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BebanTanamResource\Pages;
use App\Filament\Resources\BebanTanamResource\RelationManagers;
use App\Models\BebanTanam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BebanTanamResource extends Resource
{
    protected static ?string $model = BebanTanam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBebanTanams::route('/'),
            'create' => Pages\CreateBebanTanam::route('/create'),
            'edit' => Pages\EditBebanTanam::route('/{record}/edit'),
        ];
    }
}
