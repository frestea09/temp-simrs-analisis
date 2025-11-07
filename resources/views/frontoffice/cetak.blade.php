@extends('master')
@section('header')
  <h1>Cetak Label Rekam Medis<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/cetak', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <br>

        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>No. RM Baru</th>
              <th>No. RM Lama</th>
              <th>Nama Pasien</th>
              <th class="text-center"> Kelamin</th>
              <th class="text-center"> Tgl Registrasi</th>
              <th class="text-center">KIUP</th>
              <th class="text-center">KIB</th> 
              <th class="text-center">Barcode</th>
              <th class="text-center">Barcode 2</th>
              <th class="text-center">RM01</th>
              <th class="text-center">SEP</th>
              <th class="text-center">GELANG</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($today as $key => $d)
              @if (!empty($d->pasien_id))
                <tr class="text-center">
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm_lama : '' }}</td>
                  <td class="text-left">{{ !empty($d->pasien_id) ? strtoupper($d->pasien->nama) : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->kelamin : '' }}</td>
                  <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                  <td><a href="{{ url('frontoffice/cetak-kiup/'.$d->id) }}" target="_blank"  class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td>
                  <td><a href="{{ url('frontoffice/cetak_buktiregistrasi/'.$d->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td>
                  <td> <a href="{{ url('frontoffice/cetak_barcode/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td> <a href="{{ url('frontoffice/cetak_barcode2/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a> </td>
                  <td>
                    <a href="{{ url('frontoffice/cetak-rm01/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                  </td>
                  <td>
                    @if (!empty($d->no_sep))
                      <a href="{{ url('cetak-sep/'.$d->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('tindakan/cetak-gelang/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>

@endsection
