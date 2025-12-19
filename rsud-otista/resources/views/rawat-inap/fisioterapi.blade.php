@extends('master')
@section('header')
  <h1>Rawat Inap - Fisioterapi <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Pendaftaran Fisioterapi</h4>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th colspan="4">Data Pasien</th>
            </tr>
            <tr>
              <th>Nama</th>
              <th>No. RM</th>
              <th>Alamat</th>
              <th>Dokter</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $reg->pasien->nama }}</td>
              <td>{{ $reg->pasien->no_rm }}</td>
              <td>{{ $reg->pasien->alamat }}</td>
              <td>{{ $reg->dokter->nama }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      {{-- @if ($ibs->count() > 0)
        <h4>Pendaftaran Sebelumnya</h4>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Rencana Operasi</th>
                <th>Suspect</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ibs as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ tgl_indo($d->rencana_operasi) }}</td>
                  <td>{!! $d->suspect !!}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif --}}
        @include('tinymce')
          {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/save-ibs', 'class' => 'form-horizontal']) !!}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('rawatinap_id', $irna->id) !!}
              {!! Form::hidden('no_rm', $reg->pasien->no_rm) !!}

              <div class="form-group{{ $errors->has('pemeriksaan') ? ' has-error' : '' }}">
                  {!! Form::label('pemeriksaan', 'Pemeriksaan', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::textarea('pemeriksaan', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('pemeriksaan') }}</small>
                  </div>
              </div>

              <div class="btn-group pull-right">
                  <a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning btn-flat">Batal</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
          {!! Form::close() !!}


    </div>
  </div>
@endsection
