<x-filament-panels::page>
    <div class="space-y-6">
        <div class="max-w-xl">
            {{ $this->form }}
        </div>

        @if ($hasil)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-gray-900/40 border border-gray-800">
                    <div class="text-xs font-semibold text-gray-400">Kode Tanam</div>
                    <div class="text-lg font-semibold text-white">
                        {{ $hasil['tanam']['kode_tanam'] }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        {{ $hasil['tanam']['komoditas'] }} – {{ $hasil['tanam']['petani'] }}
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-gray-900/40 border border-gray-800">
                    <div class="text-xs font-semibold text-gray-400">Volume Panen</div>
                    <div class="text-lg font-semibold text-white">
                        {{ number_format($hasil['tanam']['volume'] ?? 0, 2, ',', '.') }}
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-gray-900/40 border border-gray-800">
                    <div class="text-xs font-semibold text-gray-400">Total Biaya Produksi</div>
                    <div class="text-lg font-semibold text-white">
                        Rp {{ number_format($hasil['ringkasan']['total_biaya'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-filament::section>
                    <x-slot name="heading">Ringkasan Biaya & Pendapatan</x-slot>

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
                        <div class="flex justify-between">
                            <dt>Keuntungan Bersih</dt>
                            <dd>Rp {{ number_format($hasil['ringkasan']['keuntungan'] ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between font-semibold">
                            <dt>CMPU</dt>
                            <dd>
                                @if ($hasil['ringkasan']['cmpu'] ?? null)
                                    Rp {{ number_format($hasil['ringkasan']['cmpu'], 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </x-filament::section>

                <x-filament::section>
                    <x-slot name="heading">Rekap Biaya per Kelompok</x-slot>

                    <dl class="space-y-1 text-sm">
                        @foreach (['BBB', 'BTKL', 'BOP', 'LAIN'] as $kategori)
                            <div class="flex justify-between">
                                <dt>{{ $kategori }}</dt>
                                <dd>
                                    Rp {{ number_format($hasil['detail_biaya'][$kategori]['subtotal'] ?? 0, 0, ',', '.') }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </x-filament::section>
            </div>

            <x-filament::section>
                <x-slot name="heading">Detail Biaya Produksi</x-slot>

                @foreach (['BBB', 'BTKL', 'BOP', 'LAIN'] as $kategori)
                    @php
                        $section = $hasil['detail_biaya'][$kategori] ?? null;
                    @endphp

                    @if ($section && count($section['items']) > 0)
                        <h3 class="mt-4 text-sm font-semibold">
                            {{ $kategori }}
                        </h3>
                        <table class="min-w-full text-xs mt-1">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="text-left py-1 pr-2">Kode</th>
                                    <th class="text-left py-1 pr-2">Nama Beban</th>
                                    <th class="text-right py-1 px-2">Jumlah</th>
                                    <th class="text-right py-1 px-2">Harga</th>
                                    <th class="text-right py-1 px-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($section['items'] as $row)
                                    <tr class="border-b border-gray-800/60">
                                        <td class="py-1 pr-2">{{ $row['kode_beban'] }}</td>
                                        <td class="py-1 pr-2">{{ $row['nama_beban'] }}</td>
                                        <td class="py-1 px-2 text-right">
                                            {{ number_format($row['jumlah'], 2, ',', '.') }} {{ $row['satuan'] }}
                                        </td>
                                        <td class="py-1 px-2 text-right">
                                            Rp {{ number_format($row['harga'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-1 px-2 text-right">
                                            Rp {{ number_format($row['total'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
