@extends('master')
@section('header')
  <h1>Gizi Pasien<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => 'gizi-pasien', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
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
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama </th>
              <th>No. RM</th>
              <th>DPJP</th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Pagi</th>
              <th>Siang</th>
              <th>Malam</th>
              <th>Catatan</th>
              <th>Petugas</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($gizipasien as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first()->pasien->nama }}</td>
                <td>{{ Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first()->pasien->no_rm }}</td>
                <td>{{ $d->dokter }}</td>
                <td>{{ baca_kelas($d->kelas_id) }}</td>
                <td>{{ baca_kamar($d->kamar_id) }}</td>
                <td>{{ $d->pagi }}</td>
                <td>{{ $d->siang }}</td>
                <td>{{ $d->malam }}</td>
                <td>{{ $d->catatan }}</td>
                <td>{{ $d->who_update }}</td>
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
