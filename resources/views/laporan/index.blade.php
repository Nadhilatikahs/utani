@extends('layouts.app')

@section('title', 'Laporan')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Laporan Biaya Hasil Pertanian</h1>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Form Filter -->
    <form method="GET" action="{{ route('laporan.show') }}">
    <style>
    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 1.5rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    
    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #333;
    }
    
    select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 1rem;
        font-size: 1rem;
        color: #333;
        background-color: #fff;
    }
    
    button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    button:hover {
        background-color: #0056b3;
    }
    
    /* Responsive design for smaller screens */
    @media (max-width: 600px) {
        form {
            padding: 1rem;
        }
        
        select,
        button {
            width: 100%;
        }
    }
</style>
</head>
<body>
    <div class="form-container">
        <h1>Filter Berdasarkan Kode Tanam</h1>
        <form method="GET" action="{{ route('laporan.show') }}">
            <label for="filter_id_tanam">Filter berdasarkan Kode Tanam:</label>
            <select id="filter_id_tanam" name="filter_id_tanam" required>
                <option value="">Pilih Kode Tanam</option>
                @foreach($kodeTanamList as $id_tanam => $kode)
                    <option value="{{ $id_tanam }}" {{ old('filter_id_tanam', $filter ?? '') == $id_tanam ? 'selected' : '' }}>
                        {{ $kode }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>
</body>

</form>

    <style>
        body {
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
        th.no, td.no {
            width: 50px;
        }
        .section-title {
            margin-top: 40px;
        }
        .sub-title {
            margin-top: 20px;
        }
    </style>

    
@endsection
