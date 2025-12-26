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

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Margin Kontribusi';
    protected static ?string $navigationGroup = '📄 Laporan';
    protected static ?int    $navigationSort  = 20;

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
                            ->mapWithKeys(fn (Tanam $t) => [
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

        $tanam = Tanam::with([
                'panens',
                'bebanTanams.beban',
                'lahan.petani',
                'komoditas',
            ])
            ->findOrFail($tanamId);

        // ==== DATA DASAR ====
        $pendapatan  = $tanam->total_pendapatan;       // Σ (jumlah * harga)
        $biayaVar    = $tanam->total_biaya_variabel;   // Σ beban variabel
        $biayaTetap  = $tanam->total_biaya_tetap;      // beban_fix
        $totalBiaya  = $tanam->total_biaya;            // var + tetap
        $labaBersih  = $tanam->keuntungan_bersih;      // pendapatan - totalBiaya (atau kolom keuntungan)
        $volume      = $tanam->panens->sum('jumlah') ?: $tanam->volume_panen;

        // ==== PERHITUNGAN PER UNIT ====
        $hargaPerUnit        = $volume > 0 ? $pendapatan  / $volume : null;
        $biayaVarPerUnit     = $volume > 0 ? $biayaVar    / $volume : null;
        $marginKontribusiPU  = $volume > 0 ? ($pendapatan - $biayaVar) / $volume : null;

        // jika harga jual atau margin per unit nol, beberapa rasio tidak bisa dihitung
        $rasioMarginKontribusi = ($hargaPerUnit && $marginKontribusiPU)
            ? $marginKontribusiPU / $hargaPerUnit
            : null;

        // ==== BREAK EVEN POINT ====
        $bepUnit  = ($marginKontribusiPU && $marginKontribusiPU > 0)
            ? $biayaTetap / $marginKontribusiPU
            : null;

        $bepRupiah = ($rasioMarginKontribusi && $rasioMarginKontribusi > 0)
            ? $biayaTetap / $rasioMarginKontribusi
            : null;

        // Margin keamanan (safety margin) opsional
        $penjualanBEP   = $bepRupiah ?? 0;
        $marginKeamanan = $pendapatan > 0
            ? $pendapatan - $penjualanBEP
            : null;

        $marginKeamananPersen = ($pendapatan > 0 && ! is_null($marginKeamanan))
            ? $marginKeamanan / $pendapatan
            : null;

        // ==== SIMPAN KE ARRAY HASIL ====
        $this->hasil = [
            'tanam' => [
                'kode_tanam'  => $tanam->kode_tanam,
                'komoditas'   => $tanam->komoditas->nama_komoditas,
                'petani'      => $tanam->lahan->petani->nama_anggota,
                'volume'      => $volume,
            ],

            'ringkasan' => [
                'pendapatan'   => $pendapatan,
                'biaya_var'    => $biayaVar,
                'biaya_tetap'  => $biayaTetap,
                'total_biaya'  => $totalBiaya,
                'laba_bersih'  => $labaBersih,
            ],

            'per_unit' => [
                'harga_jual_per_unit'       => $hargaPerUnit,
                'biaya_variabel_per_unit'   => $biayaVarPerUnit,
                'margin_kontribusi_per_unit'=> $marginKontribusiPU,
                'rasio_margin_kontribusi'   => $rasioMarginKontribusi,
            ],

            'bep' => [
                'bep_unit'    => $bepUnit,
                'bep_rupiah'  => $bepRupiah,
            ],

            'margin_keamanan' => [
                'nominal' => $marginKeamanan,
                'persen'  => $marginKeamananPersen,
            ],
        ];
    }

    /**
     * Tombol header: Download PDF
     */
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
