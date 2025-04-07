<h2>Laporan Kas</h2>
<table border="1">
    <tr>
        <th>Jenis</th>
        <th>Tanggal</th>
        <th>Jumlah</th>
        <th>Deskripsi</th>
    </tr>
    @foreach($cashTransactions as $transaction)
    <tr>
        <td>{{ $transaction->transaction_type }}</td>
        <td>{{ $transaction->transaction_date }}</td>
        <td>{{ $transaction->amount }}</td>
        <td>{{ $transaction->description }}</td>
    </tr>
    @endforeach
</table>

<h2>Jurnal Umum</h2>
<table border="1">
    <tr>
        <th>Tanggal</th>
        <th>Akun</th>
        <th>Debit</th>
        <th>Kredit</th>
        <th>Deskripsi</th>
    </tr>
    @foreach($journals as $journal)
    <tr>
        <td>{{ $journal->transaction_date }}</td>
        <td>{{ $journal->account_name }}</td>
        <td>{{ $journal->debit }}</td>
        <td>{{ $journal->credit }}</td>
        <td>{{ $journal->description }}</td>
    </tr>
    @endforeach
</table>