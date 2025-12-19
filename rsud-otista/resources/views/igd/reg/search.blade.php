@extends('master')
@section('header')
  <h1>Registrasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Hasil Pencarian Pasien &nbsp;
        <a href="{{ route('registrasi') }}" class="btn btn-info btn-sm"><i class="fa fa-search-plus"> </i> Cari Lagi</a>
      </h3>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Nomor RM</th>
              <th>Alamat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @if ($data->count() > 0)
              @foreach ($data as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->no_rm }}</td>
                    <td>{{ $d->alamat }}</td>
                    <td>
                      <a href="{{ route('registrasi.create', $d->id) }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                    </td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="5">Tidak ditemukan data dengan kata kunci tersebut</td>
              </tr>
            @endif


          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
