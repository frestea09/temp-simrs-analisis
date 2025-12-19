@extends('master')

@section('header')
  <h1>Laporan Rawat Inap By Kelas Rawat</h1>
@endsection

@section('content')
	<div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Periode Tanggal</h3>
        </div>
		<div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'rawatinap/laporan-kelasrawat', 'class'=>'form-horizontal']) !!}
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                            <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                            </span>
                            {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('tga') }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai Tanggal</button>
                        </span>
                            {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
                        <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                        <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">
                    </div>
                </div>
            {!! Form::close() !!}
            <hr>
            <div class='table-responsive'>
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            @php($total = [])
                            <th>No</th>
                            <th>Bangsal</th>
                            @foreach ($kelas as $k => $kl)
                                @php($total[$k] = 0)
                                <th>{{ $kl->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bangsal as $bs)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ baca_kelompok($bs->id) }}</td>
                                @foreach ($kelas as $k => $kl)
                                    @php($lapTotal = lapByKelasRawat($bs->id, $kl->id, 'TI', $tga, $tgb))
                                    @php($total[$k] += $lapTotal)
                                    <td class="text-right">{{ number_format($lapTotal) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center">#</td>
                            <th>TOTAL</th>
                            @foreach ($total as $t)
                                <th class="text-right">{{ number_format($t) }}</th>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection