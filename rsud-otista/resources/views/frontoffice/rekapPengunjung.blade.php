@extends('master')
@section('header')
  <h1>Front Office - Rekap Pengunjung</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/rekap-pengunjung', 'class'=>'form-horizontal']) !!}
        <div class="row">
            <div clas="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('tgla', 'Tanggal', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('tgla', null, ['class' => 'form-control datepicker']) !!}
                            <small class="text-danger">{{ $errors->first('tgla') }}</small>
                        </div>
                        <div class="col-sm-4">
                            {!! Form::text('tglb', null, ['class' => 'form-control datepicker']) !!}
                            <small class="text-danger">{{ $errors->first('tglb') }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="cara_bayar_id" class="form-control select2">
                                <option value="" selected>[Semua]</option>
                                <option value="1" {!! ($cara_bayar == 1) ? 'selected' : '' !!}>JKN</option>
                                <option value="2" {!! ($cara_bayar == 2) ? 'selected' : '' !!}>Umum</option>
                                <option value="3" {!! ($cara_bayar == 3) ? 'selected' : '' !!}>IKS</option>
                                <option value="4" {!! ($cara_bayar == 4) ? 'selected' : '' !!}>Jasa Raharja</option>
                                <option value="5" {!! ($cara_bayar == 5) ? 'selected' : '' !!}>Jamkesda</option>
                                <option value="6" {!! ($cara_bayar == 6) ? 'selected' : '' !!}>Jampersal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="poli_id" class="form-control select2">
                                <option value="" selected>[Semua]</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->id }}" {!! ($item->id == $poli_id) ? 'selected' : '' !!}>{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-11">
                            <button type="submit" class="btn btn-success pull-right">Tampilkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr/>
        <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
                    <tr>
                        <th width="40px" class="text-center">No</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Laki-laki</th>
                        <th class="text-center">Perempuan</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>Rawat Jalan</td>
                    @foreach ($jalan as $item)
                        <td class="text-center">{{ $item }}</td>
                    @endforeach
                    </tr>
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>Rawat Inap</td>
                    @foreach ($inap as $item)
                        <td class="text-center">{{ $item }}</td>
                    @endforeach
                    </tr>
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>Rawat Darurat</td>
                    @foreach ($darurat as $item)
                        <td class="text-center">{{ $item }}</td>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
      {{--  @include('frontoffice.ajax_lap_pengunjung')  --}}
  </div>
@endsection

@section('script')
  <script>
    $('.select2').select2()
  </script>
@endsection
