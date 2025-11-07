@extends('master')
@section('header')
  <h1>Daftar Pasien Inap<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => 'index-inap', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete'=>'off', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama </th>
              <th>DPJP</th>
              <th>Kamar</th>
              <th>Bed</th>
              <th>Proses</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              @php
                $background = '';

                if (count($d->emrPemeriksaan) > 0) {
                  $background = 'rgb(188, 255, 188)';
                }

                $skrining = false;

                if (!empty($d->skrining_anak) || !empty($d->skrining_dewasa) || !empty($d->skrining_maternitas) || !empty($d->skrining_perinatologi)) {
                  $skrining = true;
                }

                if (count($d->cppt_gizi) > 0 && !empty($d->pengkajian_gizi) && !empty($d->formulir_edukasi) && $skrining) {
                  $background = 'rgb(178, 233, 255)';
                }
              @endphp
              <tr style="background-color: {{$background}}">
                <td>{{ $no++ }}</td>
                <td>{{ @$d->pasien->no_rm }}</td>
                <td>{{ @$d->pasien->nama }}</td>
                <td>{{ @$d->rawat_inap->dokter_ahli->nama }}</td>
                <td>{{ @$d->rawat_inap->kamar->nama }}</td>
                <td>{{ @$d->rawat_inap->bed->nama }}</td>
                <td>
                  <a href="{{ url('emr-soap/pemeriksaan-gizi/inap/' . $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
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
