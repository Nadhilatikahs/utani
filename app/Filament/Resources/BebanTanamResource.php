<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BebanTanamResource\Pages;
use App\Models\BebanTanam;
use App\Models\Tanam;
use App\Models\Beban;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BebanTanamResource extends Resource
{
    protected static ?string $model = BebanTanam::class;

    protected static ?string $modelLabel = 'Beban Tanam';
    protected static ?string $pluralModelLabel = 'Beban Tanam';

    protected static ?string $navigationIcon  = 'heroicon-o-receipt-percent';
    protected static ?string $navigationLabel = 'Beban Tanam';
    protected static ?string $navigationGroup = '🌱 Pencatatan Usaha';
    protected static ?int    $navigationSort  = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_bebantanam')
                ->label('Kode Beban Tanam')
                ->required()
                ->maxLength(50),

            Forms\Components\Select::make('id_tanam')
                ->label('Tanam')
                ->options(
                    Tanam::with('lahan.petani', 'komoditas')
                        ->get()
                        ->mapWithKeys(fn ($t) => [
                            $t->id_tanam => $t->kode_tanam
                                .' - '.$t->komoditas->nama_komoditas
                                .' ('.$t->lahan->petani->nama_anggota.')',
                        ])
                )
                ->searchable()
                ->required(),

            Forms\Components\Select::make('id_beban')
                ->label('Beban')
                ->options(
                    Beban::all()->mapWithKeys(fn ($b) => [
                        $b->id_beban => $b->kode_beban.' - '.$b->nama_beban.' ('.$b->kategori.')',
                    ])
                )
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('satuan')
                ->required()
                ->maxLength(11),

            Forms\Components\TextInput::make('jumlah')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('harga')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('total')
                ->numeric()
                ->disabled()
                ->dehydrated(false)
                ->helperText('Total dihitung otomatis saat simpan.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_bebantanam')
                    ->label('Kode')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanam.kode_tanam')
                    ->label('Tanam'),

                Tables\Columns\TextColumn::make('tanam.komoditas.nama_komoditas')
                    ->label('Komoditas'),

                Tables\Columns\TextColumn::make('beban.nama_beban')
                    ->label('Beban'),

                Tables\Columns\TextColumn::make('beban.kategori')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR', true),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR', true),
            ])
            ->defaultSort('id_bebantanam', 'desc')
            ->actions([
                // Tidak pakai ViewAction supaya aman (hanya Edit)
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBebanTanams::route('/'),
            'create' => Pages\CreateBebanTanam::route('/create'),
            'edit'   => Pages\EditBebanTanam::route('/{record}/edit'),
        ];
    }
}
