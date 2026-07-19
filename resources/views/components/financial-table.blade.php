{{-- resources/views/components/financial-table.blade.php --}}
<div class="rpt-card">
    @if(!empty($title))
        <div class="rpt-card-header">
            @if(!empty($icon))
                <i class="{{ $icon }} mr-2"></i>
            @endif
            {{ $title }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table-financial" style="table-layout: fixed; width: 100%;">
            <colgroup>
                <col style="width: 8%;">
                <col style="width: 32%;">
                <col style="width: 40%;">
                <col style="width: 20%;">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Keterangan</th>
                    <th>Detail / Perhitungan</th>
                    <th class="text-right">Nilai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $index => $row)
                    @php
                        $isTotal = !empty($row['is_total']) || !empty($row['is_grand_total']);
                        $rowClass = '';
                        if (!empty($row['is_grand_total'])) {
                            $rowClass = 'row-grand-total';
                        } elseif (!empty($row['is_total'])) {
                            $rowClass = 'row-total-vc';
                        } elseif (!empty($row['class'])) {
                            $rowClass = $row['class'];
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="text-center text-muted">{{ $row['no'] ?? ($isTotal ? '' : $index + 1) }}</td>
                        <td class="{{ $isTotal ? 'font-weight-bold' : '' }}">{!! $row['keterangan'] !!}</td>
                        <td class="{{ !empty($row['is_formula']) ? 'font-italic text-muted' : '' }}">{!! $row['detail'] !!}</td>
                        <td class="text-right font-weight-bold" style="white-space: nowrap;">{!! $row['nilai'] !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block" style="opacity:0.4;"></i>
                            Tidak ada data keuangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
