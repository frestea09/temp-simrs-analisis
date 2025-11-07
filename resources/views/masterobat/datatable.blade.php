@extends('master')
@section('header')
  <h1>Master Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Obat  &nbsp;
          <a href="{{ route('masterobat.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table id='tableObat' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satuan Beli</th>
                <th>Satuan Jual</th>
                <th>Kategori</th>
                <th>Harga Umum</th>
                <th>Harga JKN</th>
                {{-- <th>Harga Kesda</th> --}}
                <th>Harga Beli</th>
                <th>ID Medication</th>
                <th>Aksi</th>
              </tr>
            </thead>

          </table>
        </div>


      </div>
    </div>
@stop
