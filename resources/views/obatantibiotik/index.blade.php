@extends('master')
@section('header')
  <h1>Master Obat Antibiotik</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Obat Antibiotik&nbsp;
          <a href="{{ route('obat-antibiotik.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            @php
              $no = 1;
            @endphp
            <tbody>
              @foreach ($obatAntibiotik as $data)
                <tr>
                  <td style="width: 5%;">{{ $no++ }}</td>
                  <td>{{ $data->masterobat->nama }}</td>
                  <td class="text-center">
                    <a href="{{ route('obat-antibiotik.edit', $data->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>&nbsp;
                    <a href="{{ route('obat-antibiotik.destroy', $data->id) }}" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
