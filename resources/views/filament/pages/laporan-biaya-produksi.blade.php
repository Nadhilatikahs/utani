<x-filament-panels::page>
    <div class="space-y-6">
        <div class="max-w-xl">
            {{ $this->form }}
        </div>

        @if ($hasil)
            <x-filament::section>
                <x-slot name="heading">
                    Ringkasan Biaya Produksi
                </x-slot>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Kode Tanam:</strong> {{ $hasil['kode_tanam'] }}</p>
                        <p><strong>Komoditas:</strong> {{ $hasil['komoditas'] }}</p>
                        <p><strong>Petani:</strong> {{ $hasil['petani'] }}</p>
                        <p><strong>Volume (fisik):</strong> {{ number_format($hasil['volume'] ?? 0, 2) }}</p>
                    </div>

                    <div>
                        <p><strong>Pendapatan:</strong> Rp {{ number_format($hasil['pendapatan'], 0, ',', '.') }}</p>
                        <p><strong>Biaya Variabel:</strong> Rp {{ number_format($hasil['biaya_var'], 0, ',', '.') }}</p>
                        <p><strong>Biaya Tetap:</strong> Rp {{ number_format($hasil['biaya_tetap'], 0, ',', '.') }}</p>
                        <p><strong>Total Biaya:</strong> Rp {{ number_format($hasil['total_biaya'], 0, ',', '.') }}</p>
                        <p><strong>Keuntungan:</strong> Rp {{ number_format($hasil['keuntungan'], 0, ',', '.') }}</p>
                        @if (!is_null($hasil['cmpu']))
                            <p><strong>CMPU:</strong> Rp {{ number_format($hasil['cmpu'], 0, ',', '.') }} / unit</p>
                        @endif
                    </div>
                </div>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
