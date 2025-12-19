@extends('master')
@section('header')
  <h1>Master Batch </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Batch  &nbsp;
          <a href="{{ route('masterbatch.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table id='tableObatBatches' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satuan Beli</th>
                <th>Satuan Jual</th>
                <th>Kategori</th>
                <th>Harga Umum</th>
                <th>Harga JKN</th>
                <th>Harga Kesda</th>
                <th>Harga Beli</th>
                <th>Edit</th>
              </tr>
            </thead>

          </table>
        </div>


      </div>
    </div>
@stop
