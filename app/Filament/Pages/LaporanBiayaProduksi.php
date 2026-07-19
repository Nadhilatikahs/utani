<?php

namespace App\Filament\Pages;

use App\Models\Tanam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions;

class LaporanBiayaProduksi extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $navigationGroup = '📄 Laporan';
    protected static ?int    $navigationSort  = 10;

    protected static string $view = 'filament.pages.laporan-biaya-produksi';

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

        $pendapatan = $tanam->total_pendapatan;
        $biayaVar   = $tanam->total_biaya_variabel;
        $biayaTetap = $tanam->total_biaya_tetap;
        $totalBiaya = $tanam->total_biaya;
        $laba       = $tanam->keuntungan_bersih;

        $volume = $tanam->panens->sum('jumlah') ?: $tanam->volume_panen;
        $cmpu   = $volume > 0 ? $totalBiaya / $volume : null;

        $detailByKategori = [
            'BBB'  => ['items' => [], 'subtotal' => 0],
            'BTKL' => ['items' => [], 'subtotal' => 0],
            'BOP'  => ['items' => [], 'subtotal' => 0],
            'LAIN' => ['items' => [], 'subtotal' => 0],
        ];

        foreach ($tanam->bebanTanams as $bt) {
            $kategori = strtoupper($bt->beban->kategori ?? 'LAIN');
            if (! in_array($kategori, ['BBB', 'BTKL', 'BOP'], true)) {
                $kategori = 'LAIN';
            }

            $detailByKategori[$kategori]['items'][] = [
                'kode_beban' => $bt->beban->kode_beban ?? null,
                'nama_beban' => $bt->beban->nama_beban ?? null,
                'satuan'     => $bt->satuan,
                'jumlah'     => $bt->jumlah,
                'harga'      => $bt->harga,
                'total'      => $bt->total,
            ];

            $detailByKategori[$kategori]['subtotal'] += (float) $bt->total;
        }

        $this->hasil = [
            'tanam' => [
                'kode_tanam'  => $tanam->kode_tanam,
                'komoditas'   => $tanam->komoditas->nama_komoditas ?? '-',
                'petani'      => $tanam->lahan->petani->nama_anggota ?? '-',
                'volume'      => $volume,
            ],
            'ringkasan' => [
                'pendapatan'  => $pendapatan,
                'biaya_var'   => $biayaVar,
                'biaya_tetap' => $biayaTetap,
                'total_biaya' => $totalBiaya,
                'keuntungan'  => $laba,
                'cmpu'        => $cmpu,
            ],
            'detail_biaya' => $detailByKategori,
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
            'exports.laporan-biaya-produksi-pdf',
            ['hasil' => $this->hasil]
        );

        $filename = 'laporan-biaya-produksi-'.$this->hasil['tanam']['kode_tanam'].'.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename
        );
    }
}
