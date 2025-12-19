@extends('master')

@section('header')
  <h1>Master Poli </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Poli &nbsp;
          <a href="{{ route('poli.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Poli Type</th>
                <th>BPJS</th>
                <th>Instalasi</th>
                {{-- <th>Dokter</th> --}}
                <th>ID Location Satu Sehat</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($poli as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->politype }}</td>
                  <td>{{ $d->bpjs }}</td>
                  <td>{{ $d->instalasi->nama }}</td>
                  {{-- <td>{{ baca_dokter($d->dokter_id) }}</td> --}}
                  <td>{{ @$d->id_location_ss }}</td>
                  <td>
                    <a href="{{ route('poli.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
