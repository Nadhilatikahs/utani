<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TanamResource\Pages;
use App\Models\Tanam;
use App\Models\Lahan;
use App\Models\Komoditas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TanamResource extends Resource
{
    protected static ?string $model = Tanam::class;

    protected static ?string $modelLabel = 'Tanam';
    protected static ?string $pluralModelLabel = 'Tanam';

    protected static ?string $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Tanam';
    protected static ?string $navigationGroup = '🌱 Pencatatan Usaha';
    protected static ?int    $navigationSort  = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_tanam')
                ->label('Kode Tanam')
                ->required()
                ->maxLength(15),

            Forms\Components\Select::make('id_lahan')
                ->label('Lahan')
                ->options(
                    Lahan::with('petani')
                        ->get()
                        ->mapWithKeys(fn ($l) => [
                            $l->id_lahan => $l->kode_lahan.' - '.$l->petani->nama_anggota,
                        ])
                )
                ->searchable()
                ->required(),

            Forms\Components\Select::make('id_komoditas')
                ->label('Komoditas')
                ->options(
                    Komoditas::pluck('nama_komoditas', 'id_komoditas')
                )
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('tgl_tanam')
                ->label('Tanggal Tanam')
                ->required(),

            Forms\Components\DatePicker::make('tgl_panen')
                ->label('Tanggal Panen')
                ->nullable(),

            Forms\Components\TextInput::make('volume_panen')
                ->label('Volume Panen (total)')
                ->numeric()
                ->nullable(),

            Forms\Components\TextInput::make('beban_variabel')
                ->label('Beban Variabel (summary)')
                ->numeric()
                ->nullable(),

            Forms\Components\TextInput::make('beban_fix')
                ->label('Beban Tetap (summary)')
                ->numeric()
                ->nullable(),

            Forms\Components\TextInput::make('keuntungan')
                ->label('Keuntungan (override manual)')
                ->numeric()
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_tanam')
                    ->label('Kode')
                    ->searchable(),

                Tables\Columns\TextColumn::make('lahan.petani.nama_anggota')
                    ->label('Petani')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('komoditas.nama_komoditas')
                    ->label('Komoditas')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tgl_tanam')
                    ->label('Tanggal Tanam')
                    ->date(),

                Tables\Columns\TextColumn::make('tgl_panen')
                    ->label('Tanggal Panen')
                    ->date(),

                Tables\Columns\TextColumn::make('total_pendapatan')
                    ->label('Pendapatan')
                    ->money('IDR', true),

                Tables\Columns\TextColumn::make('total_biaya')
                    ->label('Total Biaya')
                    ->money('IDR', true),

                Tables\Columns\TextColumn::make('keuntungan_bersih')
                    ->label('Keuntungan')
                    ->money('IDR', true)
                    ->color(fn ($record) => $record->keuntungan_bersih >= 0 ? 'success' : 'danger'),
            ])
            ->defaultSort('tgl_tanam', 'desc')
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
            'index'  => Pages\ListTanams::route('/'),
            'create' => Pages\CreateTanam::route('/create'),
            'edit'   => Pages\EditTanam::route('/{record}/edit'),
        ];
    }
}
