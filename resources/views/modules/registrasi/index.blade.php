@extends('master')
@section('header')
  <h1>Registrasi Pasien Lama</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {!! Form::open(['method' => 'POST', 'route' => 'registrasi.search', 'class' => 'form-search']) !!}
      <label for="keyword" class="text text-primary">Cari Pasien: {{ session('idlama') }}</label>
      <div class="input-group input-group-md">
            <span class="input-sm input-group-addon">
              <a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-sm"><i class="fa fa-backward"></i></a>
            </span>
            <input type="text" name="keyword" id="keyword" class="typeahead form-control" placeholder="Ketik nama, alamat, atau Nomor RM">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> CARI</button>
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
                    <th>Nomor RM Lama</th>
                    <th>Penangung Jawab</th>
                    <th>Alamat</th>
                    <th>Proses</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $d)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $d->nama }}</td>
                          <td>{{ $d->no_rm }}</td>
                          <td>{{ $d->no_rm_lama }}</td>
                          <td>{{ $d->pj }}</td>
                          <td>{{ $d->alamat }}</td>
                          <td>
                            @if (session('igdlama') == true)
                              <a href="{{ url('registrasi/igd/jkn/'.$d->id) }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                            @elseif (session('jenis') == 'umum')
                              <a href="{{ url('registrasi/create_umum/'. $d->id) }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                            @elseif (session('igdumum-lama') == true)
                              <a href="{{ url('registrasi/igd/umum/'.$d->id) }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                            @else
                              <a href="{{ route('registrasi.create', $d->id) }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                            @endif
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
