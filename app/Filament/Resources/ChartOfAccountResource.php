<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChartOfAccountResource\Pages;
use App\Models\ChartOfAccount;
use App\Models\JenisTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChartOfAccountResource extends Resource
{
    protected static ?string $model = ChartOfAccount::class;

    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = '📚 Data Utama';
    protected static ?int    $navigationSort  = 42;

    protected static ?string $modelLabel       = 'COA';
    protected static ?string $pluralModelLabel = 'COA';
    protected static ?string $navigationLabel  = 'COA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_akun')
                    ->label('Kode Akun')
                    ->required()
                    ->maxLength(10),

                Forms\Components\TextInput::make('nama_akun')
                    ->label('Nama Akun')
                    ->required()
                    ->maxLength(100),

                Forms\Components\Select::make('id_jenis_transaksi')
                    ->label('Jenis Transaksi')
                    ->options(JenisTransaksi::query()->pluck('keterangan', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('header')
                    ->label('Header')
                    ->maxLength(50),

                Forms\Components\Select::make('posisi_dr_cr')
                    ->label('Posisi (D/K)')
                    ->options([
                        'd' => 'Debit',
                        'k' => 'Kredit',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('saldo_awal')
                    ->label('Saldo Awal')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_akun')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_akun')
                    ->label('Nama Akun')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenisTransaksi.keterangan')
                    ->label('Jenis Transaksi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('header')
                    ->label('Header'),

                Tables\Columns\TextColumn::make('posisi_dr_cr')
                    ->label('Posisi'),

                Tables\Columns\TextColumn::make('saldo_awal')
                    ->label('Saldo Awal')
                    ->sortable()
                    ->money('IDR', true),
            ])
            ->defaultSort('kode_akun')
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
            'index'  => Pages\ListChartOfAccounts::route('/'),
            'create' => Pages\CreateChartOfAccount::route('/create'),
            'edit'   => Pages\EditChartOfAccount::route('/{record}/edit'),
        ];
    }
}
