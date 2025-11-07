@extends('master')
@section('header')
  <h1>Registrasi Online</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pendaftaran Online</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'saderek/pendaftaran-online', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-4 control-label">Periode</label>
            <div class="col-sm-4">
              <input class="form-control datepicker" name="tga" type="text" value="{{ $tga }}" required>
            </div>
            <div class="col-sm-4">
              <input class="form-control datepicker" name="tgb" type="text" value="{{ $tgb }}" required>
            </div>
          </div>
        </div>
        {{-- <div class="col-md-4">
          <div class="form-group">
            <label class="col-sm-3 control-label">Status</label>
            <div class="col-sm-7">
              {!! Form::select('status', ['pending' => 'pending','terdaftar' => 'terdaftar'], $status, ['class' => 'form-control select2']) !!}
            </div>
          </div>
        </div> --}}
        <div class="col-md-2">
          <div class="form-group">
            <button class="btn btn-primary" type="submit" >TAMPILKAN</button>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center">No</th>
                {{-- <th>No RM</th> --}}
                <th>Nama</th>
                <th>Poli</th>
                <th>Cara Bayar</th>
                <th>Tanggal Periksa</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
            @isset($reg)
            @foreach($reg as $k)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    {{-- <td>
                      {{ !empty($k->no_rm) ? $k->no_rm : 'Dari Mobile JKN' }}
                    </td> --}}
                    <td>
                      {{ !empty($k->nama) ? $k->nama : 'Dari Mobile JKN' }}
                    </td>
                    <td>{{ isset($k->data_poli->nama) ? $k->data_poli->nama : "-" }}</td>
                    <td class="text-center">
                      {{ !empty($k->carabayar) ? baca_carabayar($k['kode_cara_bayar']) : 'JKN' }}
                    </td>
                    <td class="text-center">{{ $k['tglperiksa'] }}</td>
                    <td class="text-center">
                      -
                        {{-- @if($k['status'] == 'pending')
                          <a href="{{ url('pendaftaran/regPendaftaran/'.$k['id']) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a>
                        @else
                          <a class="btn btn-default btn-sm"><i class="fa fa-check"></i></a>
                        @endif --}}
                    </td>
                </tr>
            @endforeach
            @endisset
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $('.table').DataTable();
    $('.select2').select2();
    $(".datepicker").datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    });
  </script>
@endsection
