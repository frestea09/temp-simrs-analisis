@extends('master')
@section('header')
  <h1>Master Split </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Split &nbsp;
          <a href="{{ route('mastersplit.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Master Split</th>
                <th>Kategori Header</th>
                <th>Tahun Tarif</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($master as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->id) ? @$d->nama : NULL }}</td>
                  <td>{{ !empty($d->kategoriheader->id) ? @$d->kategoriheader->nama : NULL }}</td>
                  <td>{{ !empty($d->tahuntarif->id) ? @$d->tahuntarif->tahun : NULL }}</td>
                  <td class="text-center">
                    <a href="{{ route('mastersplit.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>&nbsp;
                    <a href="{{ url('mastersplit/delete', $d->id) }}" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
