<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Form pilih Tanam --}}
        <div class="max-w-xl">
            {{ $this->form }}
        </div>

        @if ($hasil)
            {{-- Ringkasan umum --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-gray-900/40 border border-gray-800">
                    <div class="text-xs font-semibold text-gray-400">Kode Tanam</div>
                    <div class="text-lg font-semibold text-white">
                        {{ $hasil['tanam']['kode_tanam'] }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        {{ $hasil['tanam']['komoditas'] }} –
                        {{ $hasil['tanam']['petani'] }}
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-gray-900/40 border border-gray-800">
                    <div class="text-xs font-semibold text-gray-400">Volume Panen</div>
                    <div class="text-lg font-semibold text-white">
                        {{ number_format($hasil['tanam']['volume'] ?? 0, 2, ',', '.') }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        Dalam satuan panen (kg / ton) sesuai input
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-gray-900/40 border border-gray-800">
                    <div class="text-xs font-semibold text-gray-400">Keuntungan Bersih</div>
                    <div class="text-lg font-semibold text-white">
                        Rp {{ number_format($hasil['ringkasan']['laba_bersih'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Ringkasan pendapatan & biaya --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-filament::section>
                    <x-slot name="heading">Ringkasan Pendapatan & Biaya</x-slot>

                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt>Pendapatan</dt>
                            <dd>Rp {{ number_format($hasil['ringkasan']['pendapatan'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Biaya Variabel</dt>
                            <dd>Rp {{ number_format($hasil['ringkasan']['biaya_var'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Biaya Tetap</dt>
                            <dd>Rp {{ number_format($hasil['ringkasan']['biaya_tetap'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between font-semibold">
                            <dt>Total Biaya Produksi</dt>
                            <dd>Rp {{ number_format($hasil['ringkasan']['total_biaya'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </x-filament::section>

                <x-filament::section>
                    <x-slot name="heading">Perhitungan Per Unit</x-slot>

                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt>Harga Jual per Unit</dt>
                            <dd>
                                @if ($hasil['per_unit']['harga_jual_per_unit'] ?? null)
                                    Rp {{ number_format($hasil['per_unit']['harga_jual_per_unit'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Biaya Variabel per Unit</dt>
                            <dd>
                                @if ($hasil['per_unit']['biaya_variabel_per_unit'] ?? null)
                                    Rp {{ number_format($hasil['per_unit']['biaya_variabel_per_unit'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Margin Kontribusi per Unit</dt>
                            <dd>
                                @if ($hasil['per_unit']['margin_kontribusi_per_unit'] ?? null)
                                    Rp {{ number_format($hasil['per_unit']['margin_kontribusi_per_unit'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Rasio Margin Kontribusi</dt>
                            <dd>
                                @if ($hasil['per_unit']['rasio_margin_kontribusi'] ?? null)
                                    {{ number_format($hasil['per_unit']['rasio_margin_kontribusi'] * 100, 2, ',', '.') }}%
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </x-filament::section>
            </div>

            {{-- BEP & Margin Keamanan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-filament::section>
                    <x-slot name="heading">Break Even Point (BEP)</x-slot>

                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt>BEP (Unit)</dt>
                            <dd>
                                @if ($hasil['bep']['bep_unit'] ?? null)
                                    {{ number_format($hasil['bep']['bep_unit'], 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>BEP (Rupiah)</dt>
                            <dd>
                                @if ($hasil['bep']['bep_rupiah'] ?? null)
                                    Rp {{ number_format($hasil['bep']['bep_rupiah'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </x-filament::section>

                <x-filament::section>
                    <x-slot name="heading">Margin Keamanan</x-slot>

                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt>Margin Keamanan (Rp)</dt>
                            <dd>
                                @if ($hasil['margin_keamanan']['nominal'] ?? null)
                                    Rp {{ number_format($hasil['margin_keamanan']['nominal'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Margin Keamanan (%)</dt>
                            <dd>
                                @if ($hasil['margin_keamanan']['persen'] ?? null)
                                    {{ number_format($hasil['margin_keamanan']['persen'] * 100, 2, ',', '.') }}%
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </x-filament::section>
            </div>
        @endif
    </div>
</x-filament-panels::page>
