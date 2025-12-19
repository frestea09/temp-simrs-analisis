@extends('master')
@section('header')
  <h1>Master Pagu </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Pagu &nbsp;
          <a href="{{ route('masterpagu.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Biaya</th>
                <th>Diagnosa Awal</th>
                <th>Kelas</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pagu as $key => $p)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ number_format($p->biaya) }}</td>
                  <td>{{ $p->diagnosa_awal }}</td>
                  <td>{{ @$p->kelas->nama }}</td>
                  <td class="text-center">
                    <a href="{{ route('masterpagu.edit', $p->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>&nbsp;
                    <a href="{{ route('masterpagu.destroy', $p->id) }}" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
