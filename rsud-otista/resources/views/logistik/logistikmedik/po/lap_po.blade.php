@extends('master')
@section('header')
<h1>Laporan Po </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan/po', 'class'=>'form-hosizontal']) !!}
    <div class="row">
      <div class="col-md-5">
        <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
          <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
          </span>
          {!! Form::text('tga', !empty($_POST['tga']) ? $_POST['tga'] : '', ['class' => 'form-control datepicker',
          'required' => 'required']) !!}
          <small class="text-danger">{{ $errors->first('tga') }}</small>
        </div>
      </div>

      <div class="col-md-5">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">s/d Tanggal</button>
          </span>
          {!! Form::text('tgb', !empty($_POST['tgb']) ? $_POST['tgb'] : '', ['class' => 'form-control datepicker',
          'required' => 'required']) !!}
        </div>
      </div>
      <div class="col-md-2">
        <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
        <input type="submit" name="pdf" class="btn btn-danger btn-flat" value="CETAK" formtarget="_blank">
      </div>
    </div>
    {!! Form::close() !!}
    <hr>
    {{-- ================================================================================================== --}}
    <div class='table-responsive'>
      <table class="table table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>No. PO</th>
            <th>Supplier</th>
            <th>Tanggal</th>
            {{-- <th class="text-center">Total Harga</th> --}}
            <th class="text-center">Cetak</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($po as $d)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->no_po }}</td>
            <td>{{ $d->supplier }}</td>
            <td>{{ $d->tanggal }}</td>
            {{-- <td class="text-right">{{ number_format(\App\Logistik\Po::where('no_po', $d->no_po)->sum('total_hna')) }}
            </td> --}}
            <td class="text-center">
              <a href="{{ url('logistikmedik/po-cetak/'.str_replace('/', '_',$d->no_po).'/'.$d->tanggal) }}"
                target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-print"></i></a>
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