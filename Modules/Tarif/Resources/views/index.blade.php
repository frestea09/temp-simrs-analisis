@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Inap </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Tarif &nbsp;
          <a href="{{ route('tarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Akreditasi</th>
                <th>Jenis</th>
                <th>Kategori Tarif</th>
                <th>Keterangan</th>
                <th>Tahun TArif</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tarif as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ @$d->jenis_akreditasi }}
                  <td>{{ $d->jenis }}</td>
                  <td>{{ $d->kategoritarif->namatarif }}</td>
                  <td>{{ $d->keterangan }}</td>
                  <td>{{ $d->tahuntarif->tahun }}</td>
                  <td>
                    <a href="{{ route('tarif.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
