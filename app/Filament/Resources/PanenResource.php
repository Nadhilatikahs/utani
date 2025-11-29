<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PanenResource\Pages;
use App\Models\Panen;
use App\Models\Tanam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PanenResource extends Resource
{
    protected static ?string $model = Panen::class;

    protected static ?string $modelLabel = 'Panen';
    protected static ?string $pluralModelLabel = 'Panen';

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Panen';
    protected static ?string $navigationGroup = '🌱 Pencatatan Usaha';
    protected static ?int    $navigationSort  = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_panen')
                ->label('Kode Panen')
                ->required()
                ->maxLength(50),

            Forms\Components\Select::make('id_tanam')
                ->label('Tanam')
                ->options(
                    Tanam::with('komoditas')
                        ->get()
                        ->mapWithKeys(fn ($t) => [
                            $t->id_tanam => $t->kode_tanam.' - '.$t->komoditas->nama_komoditas,
                        ])
                )
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('tgal_panen')
                ->label('Tanggal Panen')
                ->required(),

            Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('harga')
                ->label('Harga per Unit')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('hasil_panen')
                ->label('Total Hasil Panen')
                ->numeric()
                ->disabled()
                ->dehydrated(false)
                ->helperText('Otomatis = jumlah × harga saat disimpan.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_panen')
                    ->label('Kode')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanam.kode_tanam')
                    ->label('Tanam'),

                Tables\Columns\TextColumn::make('tanam.komoditas.nama_komoditas')
                    ->label('Komoditas'),

                Tables\Columns\TextColumn::make('tgal_panen')
                    ->label('Tanggal Panen')
                    ->date(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR', true),

                Tables\Columns\TextColumn::make('hasil_panen')
                    ->label('Hasil Panen')
                    ->money('IDR', true),
            ])
            ->defaultSort('tgal_panen', 'desc')
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
            'index'  => Pages\ListPanens::route('/'),
            'create' => Pages\CreatePanen::route('/create'),
            'edit'   => Pages\EditPanen::route('/{record}/edit'),
        ];
    }
}
