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
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satuan Beli</th>
                <th>Satuan Jual</th>
                <th>Kategori Obat</th>
                {{-- <th>Harga Umum</th>
                <th>Harga JKN</th>
                <th>Harga Kesda</th>
                <th>Harga Beli</th> --}}
                <th>ID Medication</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($masterobat as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$e->nama }}</td>
                <td>{{ @$e->satuanbeli->nama }}</td>
                <td>{{ @$e->satuanjual->nama }}</td>
                <td>{{ @$e->kategoriobat->nama }}</td>
                <td>{{ $e->id_medication}}</td>
                {{-- <td>{{ number_format($e->hargajual) }}</td>
                <td>{{ number_format($e->hargajual_jkn) }}</td>
                <td>{{ number_format($e->hargajual_kesda) }}</td>
                <td>{{ number_format($e->hargabeli) }}</td> --}}
                <td><a href="{{ url('masterobat/'.$e->id.'/edit') }}" class="btn btn-success btn-md"><i class="fa fa-edit"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
