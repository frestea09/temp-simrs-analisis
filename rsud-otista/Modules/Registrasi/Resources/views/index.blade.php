@extends('master')
@section('header')
  <h1>Registrasi Pasien Lama</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {!! Form::open(['method' => 'POST', 'route' => 'registrasi.search', 'class' => 'form-search']) !!}
      <label for="keyword" class="text text-primary">Cari Pasien: </label>
      <div class="input-group input-group-md">
            <input type="text" name="keyword" class="form-control" placeholder="Ketik nama, alamat, atau Nomor RM">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i> CARI</button>
                </span>
          </div>
      {!! Form::close() !!}
    </div>
    <div class="box-body">
      {{-- ======================================================================================================= --}}
      <div class="row">
        <div class="col-md-12">
          @if (isset($data))
            <h4>Hasil Pencarian Pasien</h4>
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
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
                  </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
