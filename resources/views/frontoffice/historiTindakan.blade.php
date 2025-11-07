@extends('master')
@section('header')
  <h1>Riwayat Hapus Tindakan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/riwayat-hapus-tindakan', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
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
              <th>Keterangan</th>
              <th>Pengguna</th>
              <th>URL</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->text }}</td>
                <td>{{ baca_user($d->user_id) }}</td>
                <td>
                  <a target="_blank" href="{{$d->url}}">{{$d->url}}</a>
                </td>
                <td>{{date('d-m-Y H:i:s', strtotime($d->created_at))}}</td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
