<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Form pilih Tanam --}}
        <div class="max-w-xl">
            {{ $this->form }}
        </div>

        {{-- Hasil perhitungan --}}
        @if ($hasil)
            <x-filament::section>
                <x-slot name="heading">
                    Ringkasan Biaya Produksi
                </x-slot>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Kode Tanam:</strong> {{ $hasil['tanam']['kode_tanam'] }}</p>
                        <p><strong>Komoditas:</strong> {{ $hasil['tanam']['komoditas'] }}</p>
                        <p><strong>Petani:</strong> {{ $hasil['tanam']['petani'] }}</p>
                        <p><strong>Volume (fisik):</strong> {{ number_format($hasil['tanam']['volume'] ?? 0, 2) }}</p>
                    </div>

                    <div>
                        <p><strong>Pendapatan:</strong>
                            Rp {{ number_format($hasil['ringkasan']['pendapatan'], 0, ',', '.') }}
                        </p>
                        <p><strong>Biaya Variabel:</strong>
                            Rp {{ number_format($hasil['ringkasan']['biaya_var'], 0, ',', '.') }}
                        </p>
                        <p><strong>Biaya Tetap:</strong>
                            Rp {{ number_format($hasil['ringkasan']['biaya_tetap'], 0, ',', '.') }}
                        </p>
                        <p><strong>Total Biaya:</strong>
                            Rp {{ number_format($hasil['ringkasan']['total_biaya'], 0, ',', '.') }}
                        </p>
                        <p><strong>Keuntungan:</strong>
                            Rp {{ number_format($hasil['ringkasan']['keuntungan'], 0, ',', '.') }}
                        </p>
                        @if (!is_null($hasil['ringkasan']['cmpu']))
                            <p><strong>CMPU:</strong>
                                Rp {{ number_format($hasil['ringkasan']['cmpu'], 0, ',', '.') }} / unit
                            </p>
                        @endif
                    </div>
                </div>
            </x-filament::section>

            {{-- Tabel rincian biaya per kategori --}}
            @php
                $labels = [
                    'BBB'  => 'Bahan Baku Langsung (BBB)',
                    'BTKL' => 'Biaya Tenaga Kerja Langsung (BTKL)',
                    'BOP'  => 'Biaya Overhead Pabrik (BOP)',
                    'LAIN' => 'Biaya Lain-lain',
                ];
            @endphp

            @foreach ($hasil['detail_biaya'] as $kategori => $data)
                @if (count($data['items']) > 0)
                    <x-filament::section class="mt-4">
                        <x-slot name="heading">
                            {{ $labels[$kategori] ?? $kategori }}
                        </x-slot>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-2 px-2">Kode</th>
                                        <th class="text-left py-2 px-2">Nama Beban</th>
                                        <th class="text-right py-2 px-2">Jumlah</th>
                                        <th class="text-left py-2 px-2">Satuan</th>
                                        <th class="text-right py-2 px-2">Harga</th>
                                        <th class="text-right py-2 px-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['items'] as $item)
                                        <tr class="border-b">
                                            <td class="py-1 px-2">{{ $item['kode_beban'] }}</td>
                                            <td class="py-1 px-2">{{ $item['nama_beban'] }}</td>
                                            <td class="py-1 px-2 text-right">{{ number_format($item['jumlah'], 2) }}</td>
                                            <td class="py-1 px-2">{{ $item['satuan'] }}</td>
                                            <td class="py-1 px-2 text-right">
                                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                            </td>
                                            <td class="py-1 px-2 text-right">
                                                Rp {{ number_format($item['total'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="py-2 px-2 text-right font-semibold">
                                            Subtotal
                                        </td>
                                        <td class="py-2 px-2 text-right font-semibold">
                                            Rp {{ number_format($data['subtotal'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </x-filament::section>
                @endif
            @endforeach
        @endif
    </div>
</x-filament-panels::page>
