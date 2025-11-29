<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LahanResource\Pages;
use App\Filament\Resources\LahanResource\RelationManagers;
use App\Models\Lahan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LahanResource extends Resource
{
    protected static ?string $model = Lahan::class;

    protected static ?string $navigationLabel = 'Lahan';
    protected static ?string $navigationIcon  = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationGroup = '📚 Data Utama • Usaha Tani';
    protected static ?int    $navigationSort  = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_lahan')
                    ->required(),
                Forms\Components\TextInput::make('id_anggota')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('luas')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jml_petak')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_lahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_anggota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('luas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jml_petak')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListLahans::route('/'),
            'create' => Pages\CreateLahan::route('/create'),
            'edit' => Pages\EditLahan::route('/{record}/edit'),
        ];
    }
}
