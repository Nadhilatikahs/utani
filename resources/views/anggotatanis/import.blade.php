<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Form Import ')
  
@section('contents')
    <h1 class="mb-0">Anggota Tani</h1>
    <hr />
    <form action="{{ route('anggotatanis.import_proses') }}" method="POST" enctype="multipart/form-data">
        @csrf
       
<div class="card-body">
    <div class="form-group">
        <label for="exampleInputAnggota">File</label><br>
        <a href="https://docs.google.com/spreadsheets/d/15ztpRWmee_RUPwsBdJesnBrn-r0Yik5e/edit?usp=drive_link&ouid=104711689882552299457&rtpof=true&sd=true">Unduh Template Import</a>

        <input type=file class="form-control" id="exampleInputAnggota" name="file" id="fle">
         @error('file') 
         <small>{{$message}} </small>
         @enderror
</div> 
            
</div>     
 
        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection


