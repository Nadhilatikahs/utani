<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KasKeluarResource\Pages;
use App\Models\CashTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KasKeluarResource extends Resource
{
    protected static ?string $model = CashTransaction::class;

    protected static ?string $navigationIcon  = 'heroicon-o-arrow-up-circle';
    protected static ?string $navigationGroup = '💰 Keuangan';
    protected static ?int    $navigationSort  = 11;

    protected static ?string $modelLabel       = 'Kas Keluar';
    protected static ?string $pluralModelLabel = 'Kas Keluar';
    protected static ?string $navigationLabel  = 'Kas Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('transaction_date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                Forms\Components\TextInput::make('amount')
                    ->label('Nominal')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Keterangan')
                    ->rows(3),

                Forms\Components\Hidden::make('transaction_type')
                    ->default('keluar'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date('d-m-Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(40),
            ])
            ->defaultSort('transaction_date', 'desc')
            ->filters([])
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('transaction_type', 'keluar');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKasKeluars::route('/'),
            'create' => Pages\CreateKasKeluar::route('/create'),
            'edit'   => Pages\EditKasKeluar::route('/{record}/edit'),
        ];
    }
}
