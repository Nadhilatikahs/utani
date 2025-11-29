<?php

namespace App\Filament\Pages;

use App\Models\Tanam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class LaporanBiayaProduksi extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Laporan Biaya Produksi';
    protected static ?string $navigationGroup = '📄 Laporan';
    protected static ?int    $navigationSort  = 10;

    protected static string $view = 'filament.pages.laporan-biaya-produksi';

    public ?int $tanam_id = null;
    public ?array $hasil = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tanam_id')
                    ->label('Pilih Tanam')
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
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state) => $this->hitung($state)),
            ])
            ->statePath('data');
    }

    public function hitung(?int $tanamId): void
    {
        if (!$tanamId) {
            $this->hasil = null;
            return;
        }

        $tanam = Tanam::with(['panens', 'bebanTanams.beban', 'lahan.petani', 'komoditas'])
            ->findOrFail($tanamId);

        $pendapatan = $tanam->total_pendapatan;
        $biayaVar   = $tanam->total_biaya_variabel;
        $biayaTetap = $tanam->total_biaya_tetap;
        $totalBiaya = $tanam->total_biaya;
        $laba       = $tanam->keuntungan_bersih;

        $volume = $tanam->panens->sum('jumlah') ?: $tanam->volume_panen;
        $cmpu   = $volume > 0 ? $totalBiaya / $volume : null;

        $this->hasil = [
            'kode_tanam'  => $tanam->kode_tanam,
            'komoditas'   => $tanam->komoditas->nama_komoditas,
            'petani'      => $tanam->lahan->petani->nama_anggota,
            'pendapatan'  => $pendapatan,
            'biaya_var'   => $biayaVar,
            'biaya_tetap' => $biayaTetap,
            'total_biaya' => $totalBiaya,
            'keuntungan'  => $laba,
            'volume'      => $volume,
            'cmpu'        => $cmpu,
        ];
    }
}
