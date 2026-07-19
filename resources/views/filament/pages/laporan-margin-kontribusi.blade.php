<x-filament-panels::page>
    <div class="space-y-6">
        <div class="max-w-xl">
            {{ $this->form }}
        </div>

        @if ($hasil)
            <x-filament::section>
                <x-slot name="heading">Ringkasan Usaha</x-slot>

                <p class="text-sm">
                    Kode Tanam: <strong>{{ $hasil['tanam']['kode_tanam'] }}</strong><br>
                    Komoditas: {{ $hasil['tanam']['komoditas'] }}<br>
                    Petani: {{ $hasil['tanam']['petani'] }}<br>
                    Volume Panen: {{ number_format($hasil['tanam']['volume'] ?? 0, 2, ',', '.') }}
                </p>
            </x-filament::section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-filament::section>
                    <x-slot name="heading">Pendapatan & Biaya</x-slot>

                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt>Pendapatan</dt>
                            <dd>Rp {{ number_format($hasil['nilai']['pendapatan'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Biaya Variabel</dt>
                            <dd>Rp {{ number_format($hasil['nilai']['biaya_variabel'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Biaya Tetap</dt>
                            <dd>Rp {{ number_format($hasil['nilai']['biaya_tetap'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Total Biaya</dt>
                            <dd>Rp {{ number_format($hasil['nilai']['total_biaya'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </x-filament::section>

                <x-filament::section>
                    <x-slot name="heading">Margin & Titik Impas</x-slot>

                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt>Margin Kontribusi Total</dt>
                            <dd>Rp {{ number_format($hasil['nilai']['margin_total'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Harga per Unit</dt>
                            <dd>
                                @if ($hasil['nilai']['harga_per_unit'] ?? null)
                                    Rp {{ number_format($hasil['nilai']['harga_per_unit'], 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Biaya Variabel per Unit</dt>
                            <dd>
                                @if ($hasil['nilai']['biaya_variabel_unit'] ?? null)
                                    Rp {{ number_format($hasil['nilai']['biaya_variabel_unit'], 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Margin Kontribusi per Unit</dt>
                            <dd>
                                @if ($hasil['nilai']['margin_per_unit'] ?? null)
                                    Rp {{ number_format($hasil['nilai']['margin_per_unit'], 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>BEP (Unit)</dt>
                            <dd>
                                @if ($hasil['nilai']['bep_unit'] ?? null)
                                    {{ number_format($hasil['nilai']['bep_unit'], 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>BEP (Rupiah)</dt>
                            <dd>
                                @if ($hasil['nilai']['bep_rupiah'] ?? null)
                                    Rp {{ number_format($hasil['nilai']['bep_rupiah'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between font-semibold">
                            <dt>Status</dt>
                            <dd>{{ $hasil['nilai']['status'] ?? '-' }}</dd>
                        </div>
                    </dl>
                </x-filament::section>
            </div>
        @endif
    </div>
</x-filament-panels::page>
