@extends('master')
@section('header')
  <h1>Rawat Inap - Gizi<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">

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
              <td>{{ baca_dokter($reg->dokter_id) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h4>Pendaftaran Gizi</h4>
      <hr>
      {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/simpan-gizi', 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('dokter', $reg->dokter_id) !!}
          {!! Form::hidden('kelas_id', $irna->kelas_id) !!}
          {!! Form::hidden('kamar_id', $irna->kamar_id) !!}
          {!! Form::hidden('bed_id', $irna->bed_id) !!}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('pagi') ? ' has-error' : '' }}">
                  {!! Form::label('pagi', 'Pagi', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('pagi', $gizi, null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('pagi') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('siang') ? ' has-error' : '' }}">
                  {!! Form::label('siang', 'Siang', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('siang', $gizi, null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('siang') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('malam') ? ' has-error' : '' }}">
                  {!! Form::label('malam', 'Malam', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('malam', $gizi, null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('malam') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('catatan') ? ' has-error' : '' }}">
                  {!! Form::label('catatan', 'Catatan', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('catatan', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('catatan') }}</small>
                  </div>
              </div>

              <div class="btn-group pull-right">
                  <a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning">Batal</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success', 'onclick'=>'return confirm("Yakin gizi yang Anda daftarkan sudah benar?")']) !!}
              </div>
            </div>
          </div>


      {!! Form::close() !!}


    </div>
  </div>
@endsection
