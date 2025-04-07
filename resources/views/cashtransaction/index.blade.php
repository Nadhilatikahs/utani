@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cash Transactions</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->date }}</td>
                <td>{{ number_format($transaction->amount, 2) }}</td>
                <td>{{ $transaction->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection