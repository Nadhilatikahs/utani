<?php

namespace App\Filament\Pages;

use App\Models\Tanam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions;

class LaporanMarginKontribusi extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-scale';
    protected static ?string $navigationLabel = 'Laporan Margin Kontribusi';
    protected static ?string $navigationGroup = '📄 Laporan';
    protected static ?int    $navigationSort  = 20;

    protected static string $view = 'filament.pages.laporan-margin-kontribusi';

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
        if (! $tanamId) {
            $this->hasil = null;
            return;
        }

        $tanam = Tanam::with(['panens', 'bebanTanams.beban', 'lahan.petani', 'komoditas'])
            ->findOrFail($tanamId);

        $pendapatan = $tanam->total_pendapatan;

        // anggap semua BebanTanam = biaya variabel (untuk laporan MC)
        $biayaVariabelTotal = (float) $tanam->bebanTanams->sum('total');
        $biayaTetapTotal    = (float) ($tanam->beban_fix ?? 0);

        $marginKontribusiTotal = $pendapatan - $biayaVariabelTotal;

        $volume = $tanam->panens->sum('jumlah') ?: $tanam->volume_panen;
        $hargaPerUnit = $volume > 0 ? $pendapatan / $volume : null;

        $mcPerUnit = $volume > 0 ? $marginKontribusiTotal / $volume : null;

        $bepUnit   = $mcPerUnit && $mcPerUnit > 0 ? $biayaTetapTotal / $mcPerUnit : null;
        $bepRupiah = $bepUnit && $hargaPerUnit ? $bepUnit * $hargaPerUnit : null;

        $status = 'IMPAS';
        if ($pendapatan > $biayaVariabelTotal + $biayaTetapTotal) {
            $status = 'UNTUNG';
        } elseif ($pendapatan < $biayaVariabelTotal + $biayaTetapTotal) {
            $status = 'RUGI';
        }

        $this->hasil = [
            'tanam' => [
                'kode_tanam'  => $tanam->kode_tanam,
                'komoditas'   => $tanam->komoditas->nama_komoditas,
                'petani'      => $tanam->lahan->petani->nama_anggota,
                'volume'      => $volume,
                'harga_satuan'=> $hargaPerUnit,
            ],
            'pendapatan' => $pendapatan,
            'biaya_variabel' => $biayaVariabelTotal,
            'biaya_tetap'    => $biayaTetapTotal,
            'margin_total'   => $marginKontribusiTotal,
            'margin_per_unit'=> $mcPerUnit,
            'bep_unit'       => $bepUnit,
            'bep_rupiah'     => $bepRupiah,
            'status'         => $status,
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
