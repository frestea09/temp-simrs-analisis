@extends('master')
@section('header')
  <h1>Laporan Penerimaan Tunai <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Periode tanggal: </h4>
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => 'kasir/laporan-penerimaan-tunai', 'class'=>'form-hosizontal']) !!}
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

      @if (isset($tunai) || isset($piutang))
        <div class="row">
          <div class="col-md-6">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <tbody>
                  <tr>
                    <th>Pendapatan Tunai</th> <td>{{ number_format($tunai) }}</td>
                  </tr>
                  <tr>
                    <th>Piutang</th> <td>{{ number_format($piutang) }}</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Total Pendapatan</th> <th>{{ number_format(($tunai + $piutang)) }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

      @endif

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
