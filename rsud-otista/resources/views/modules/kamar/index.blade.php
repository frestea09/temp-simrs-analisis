@extends('master')

@section('header')
  <h1>Master Kamar Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Kamar &nbsp;
          <a href="{{ route('kamar.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kamar</th>
                <th>Kelompok</th>
                <th>Kelas</th>
                <th>Jumlah BED</th>
                {{-- <th>Kamar</th> --}}
                <th>Kode Kamar</th>
                {{-- <th>ID Kamar Satu Sehat</th> --}}
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($kamar as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$d->nama }}</td>
                <td>{{ baca_kelompok(@$d->kelompokkelas_id) }}</td>
                <td>{{ @$d->kelas->nama }}</td>
                <td>{{ \Modules\Bed\Entities\Bed::where('kamar_id', $d->id)->count() }}</td>
                {{-- <td>{{ $d->nama_kamar }}</td> --}}
                <td>{{ @$d->kode }}</td>
                {{-- <td>{{ $d->id_ss_kamar }}</td> --}}
                <td>
                  <a href="{{ route('kamar.edit', @$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
