<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurnalUmumResource\Pages;
use App\Models\JurnalUmum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JurnalUmumResource extends Resource
{
    protected static ?string $model = JurnalUmum::class;

    protected static ?string $navigationIcon  = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = '💰 Keuangan';
    protected static ?int    $navigationSort  = 12;

    protected static ?string $modelLabel       = 'Jurnal Umum';
    protected static ?string $pluralModelLabel = 'Jurnal Umum';
    protected static ?string $navigationLabel  = 'Jurnal Umum';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required(),

                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('kas_masuk')
                    ->label('Kas Masuk')
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('kas_keluar')
                    ->label('Kas Keluar')
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('saldo')
                    ->label('Saldo')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d-m-Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\TextColumn::make('kas_masuk')
                    ->label('Kas Masuk')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('kas_keluar')
                    ->label('Kas Keluar')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('saldo')
                    ->label('Saldo')
                    ->money('IDR', true)
                    ->sortable(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListJurnalUmums::route('/'),
            'create' => Pages\CreateJurnalUmum::route('/create'),
            'edit'   => Pages\EditJurnalUmum::route('/{record}/edit'),
        ];
    }
}
