<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailJenisTransaksiResource\Pages;
use App\Models\DetailJenisTransaksi;
use App\Models\JenisTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DetailJenisTransaksiResource extends Resource
{
    protected static ?string $model = DetailJenisTransaksi::class;

    protected static ?string $navigationIcon  = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = '📚 Data Utama';
    protected static ?int    $navigationSort  = 41;

    protected static ?string $modelLabel       = 'Detail Jenis Transaksi';
    protected static ?string $pluralModelLabel = 'Detail Jenis Transaksi';
    protected static ?string $navigationLabel  = 'Detail Jenis Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_jenis_transaksi')
                    ->label('Jenis Transaksi')
                    ->options(JenisTransaksi::query()->pluck('keterangan', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('keterangan')
                    ->label('Nama Detail Jenis')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenisTransaksi.keterangan')
                    ->label('Jenis Transaksi')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Detail')
                    ->searchable(),
            ])
            ->defaultSort('id')
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDetailJenisTransaksis::route('/'),
            'create' => Pages\CreateDetailJenisTransaksi::route('/create'),
            'edit'   => Pages\EditDetailJenisTransaksi::route('/{record}/edit'),
        ];
    }
}
