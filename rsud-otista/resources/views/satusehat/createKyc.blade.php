@extends('master')
@section('header')
  <h1>KYC Satu Sehat<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'satusehat/kyc', 'class' => 'form-vertical']) !!}
      <div class="row mt-4">
        <div class="mb-3 col-md-5">
          <label for="nama" class="form-label">Nama Pasien</label>
          <input type="text" class="form-control" name="nama">
       </div>
      </div>
      <div class="row mt-4">
        <div class="mb-3 col-md-5">
          <label for="nik" class="form-label">NIK Pasien</label>
          <input type="text" class="form-control" name="nik">
       </div>
      </div> 
      <div class="row mt-4">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
        {!! Form::close() !!}
    </div>
  </div>
@endsection
