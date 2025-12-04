@extends('master')

@section('header')
  <h1>Master Bed Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Bed &nbsp;
          <a href="{{ route('bed.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kode</th>
              <th>Reserved</th>
              <th>Keterangan</th>
              <th>Kamar</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($bed as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ $d->kode }}</td>
              <td>
                @if ($d->reserved == 'N')
                  Kosong
                @else
                  Isi
                @endif
              </td>
              <td>{{ $d->keterangan }}</td>
              <td>{{ $d->kamar->nama }}</td>
              <td>
                <a href="{{ route('bed.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
@stop
