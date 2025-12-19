@extends('master')
@section('header')
  <h1>Input Diagnosa Rawat Inap </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/input_diagnosa_rawatinap', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>No RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Tanggal Registrasi</th>
              <th>Tanggal Masuk</th>
              <th>Ruangan</th>
              <th>Umur</th>
              <th>DPJP</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)

              {{-- @php
                    $bangsal = App\Rawatinap::where('registrasi_id',$d->registrasi_id)->first();
              @endphp --}}

              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d['norm'] }}</td>
                <td>{{ $d['nama_pasien'] }}</td>
                <td>{{ $d['alamat'] }}</td>
                <td>{{ $d['tgl_regis'] }}</td>
                <td>{{ $d['tgl_masuk'] }}</td>
                <td>{{ $d['kelompok'] }}</td>
                <td>{{ $d['umur'] }}</td>
                <td>{{ $d['dokter'] }}</td>
                <td>
                  <a href="{{ url('frontoffice/form_input_diagnosa_rawatinap/'.$d['idReg']) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
