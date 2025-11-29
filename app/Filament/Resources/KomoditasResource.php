<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KomoditasResource\Pages;
use App\Models\Komoditas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KomoditasResource extends Resource
{
    protected static ?string $model = Komoditas::class;

    protected static ?string $modelLabel = 'Komoditas';
    protected static ?string $pluralModelLabel = 'Komoditas';

    protected static ?string $navigationIcon  = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Komoditas';
    protected static ?string $navigationGroup = '📚 Data Utama • Usaha Tani';
    protected static ?int    $navigationSort  = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_komoditas')
                ->label('Kode Komoditas')
                ->required()
                ->maxLength(25),

            Forms\Components\TextInput::make('nama_komoditas')
                ->label('Nama Komoditas')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('kategori')
                ->label('Kategori')
                ->nullable(),

            Forms\Components\TextInput::make('harga_satuan')
                ->label('Harga Satuan')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_komoditas')
                    ->label('Kode')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_komoditas')
                    ->label('Nama Komoditas')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->money('IDR', true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKomoditas::route('/'),
            'create' => Pages\CreateKomoditas::route('/create'),
            'edit'   => Pages\EditKomoditas::route('/{record}/edit'),
        ];
    }
}
