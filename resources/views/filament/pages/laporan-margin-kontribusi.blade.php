<x-filament-panels::page>
    <div class="space-y-6">
        <div class="max-w-xl">
            {{ $this->form }}
        </div>

        @if ($hasil)
            <x-filament::section>
                <x-slot name="heading">
                    Ringkasan Margin Kontribusi
                </x-slot>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Kode Tanam:</strong> {{ $hasil['tanam']['kode_tanam'] }}</p>
                        <p><strong>Komoditas:</strong> {{ $hasil['tanam']['komoditas'] }}</p>
                        <p><strong>Petani:</strong> {{ $hasil['tanam']['petani'] }}</p>
                        <p><strong>Volume (fisik):</strong> {{ number_format($hasil['tanam']['volume'] ?? 0, 2) }}</p>
                        <p><strong>Harga per Unit:</strong>
                            Rp {{ number_format($hasil['tanam']['harga_satuan'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p><strong>Pendapatan:</strong>
                            Rp {{ number_format($hasil['pendapatan'], 0, ',', '.') }}
                        </p>
                        <p><strong>Biaya Variabel Total:</strong>
                            Rp {{ number_format($hasil['biaya_variabel'], 0, ',', '.') }}
                        </p>
                        <p><strong>Biaya Tetap Total:</strong>
                            Rp {{ number_format($hasil['biaya_tetap'], 0, ',', '.') }}
                        </p>
                        <p><strong>Margin Kontribusi Total:</strong>
                            Rp {{ number_format($hasil['margin_total'], 0, ',', '.') }}
                        </p>
                        <p><strong>Margin Kontribusi per Unit:</strong>
                            Rp {{ number_format($hasil['margin_per_unit'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    Titik Impas (Break Even Point)
                </x-slot>

                <div class="space-y-2">
                    <p><strong>BEP (unit):</strong>
                        @if ($hasil['bep_unit'])
                            {{ number_format($hasil['bep_unit'], 2) }} unit
                        @else
                            -
                        @endif
                    </p>

                    <p><strong>BEP (Rp):</strong>
                        @if ($hasil['bep_rupiah'])
                            Rp {{ number_format($hasil['bep_rupiah'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </p>

                    <p>
                        <strong>Status Usaha:</strong>
                        @if ($hasil['status'] === 'UNTUNG')
                            <span class="text-green-600 font-semibold">UNTUNG</span>
                        @elseif ($hasil['status'] === 'RUGI')
                            <span class="text-red-600 font-semibold">RUGI</span>
                        @else
                            <span class="text-yellow-600 font-semibold">IMPAS</span>
                        @endif
                    </p>

                    @if ($hasil['bep_unit'] && $hasil['tanam']['volume'])
                        <p>
                            Dengan volume panen
                            <strong>{{ number_format($hasil['tanam']['volume'], 2) }}</strong> unit,
                            usaha ini berada pada kondisi
                            <strong>{{ $hasil['status'] }}</strong>.
                        </p>
                    @endif
                </div>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
