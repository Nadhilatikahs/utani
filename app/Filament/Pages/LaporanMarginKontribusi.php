<?php

namespace App\Filament\Pages;

use App\Models\Tanam;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class LaporanMarginKontribusi extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Laporan Keuntungan & Kerugian';
    protected static ?string $navigationGroup = '📄 Laporan';
    protected static ?int    $navigationSort  = 11;

    protected static string $view = 'filament.pages.laporan-margin-kontribusi';

    public ?int   $tanam_id = null;
    public ?array $hasil    = null;

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
                                    .' - '.($t->komoditas->nama_komoditas ?? '-')
                                    .' ('.($t->lahan->petani->nama_anggota ?? '-').')',
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
        if (! $tanamId) {
            $this->hasil = null;
            return;
        }

        $tanam = Tanam::with([
                'panens',
                'bebanTanams.beban',
                'lahan.petani',
                'komoditas',
            ])
            ->findOrFail($tanamId);

        $pendapatan  = $tanam->total_pendapatan;
        $biayaVar    = $tanam->total_biaya_variabel;
        $biayaTetap  = $tanam->total_biaya_tetap;
        $totalBiaya  = $tanam->total_biaya;
        $laba        = $tanam->keuntungan_bersih;

        $volume = $tanam->panens->sum('jumlah') ?: $tanam->volume_panen;

        $hargaPerUnit   = $volume > 0 ? $pendapatan / $volume : null;
        $biayaVarPerU   = $volume > 0 ? $biayaVar / $volume : null;
        $marginTotal    = $pendapatan - $biayaVar;
        $marginPerUnit  = ($hargaPerUnit !== null && $biayaVarPerU !== null)
            ? $hargaPerUnit - $biayaVarPerU
            : null;

        $bepUnit   = $marginPerUnit > 0 ? $biayaTetap / $marginPerUnit : null;
        $bepRupiah = ($bepUnit !== null && $hargaPerUnit !== null)
            ? $bepUnit * $hargaPerUnit
            : null;

        $status = 'Impas';
        if ($laba > 0) {
            $status = 'Untung';
        } elseif ($laba < 0) {
            $status = 'Rugi';
        }

        $this->hasil = [
            'tanam' => [
                'kode_tanam'  => $tanam->kode_tanam,
                'komoditas'   => $tanam->komoditas->nama_komoditas ?? '-',
                'petani'      => $tanam->lahan->petani->nama_anggota ?? '-',
                'volume'      => $volume,
            ],
            'nilai' => [
                'pendapatan'          => $pendapatan,
                'biaya_variabel'      => $biayaVar,
                'biaya_tetap'         => $biayaTetap,
                'total_biaya'         => $totalBiaya,
                'laba_bersih'         => $laba,
                'margin_total'        => $marginTotal,
                'harga_per_unit'      => $hargaPerUnit,
                'biaya_variabel_unit' => $biayaVarPerU,
                'margin_per_unit'     => $marginPerUnit,
                'bep_unit'            => $bepUnit,
                'bep_rupiah'          => $bepRupiah,
                'status'              => $status,
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('downloadPdf')
                ->visible(fn (self $livewire) => ! is_null($livewire->hasil)),
        ];
    }

    public function downloadPdf()
    {
        if (! $this->tanam_id) {
            return;
        }

        $this->hitung($this->tanam_id);

        $pdf = app('dompdf.wrapper')->loadView(
            'exports.laporan-margin-kontribusi-pdf',
            ['hasil' => $this->hasil]
        );

        $filename = 'laporan-margin-kontribusi-'.$this->hasil['tanam']['kode_tanam'].'.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename
        );
    }
}
