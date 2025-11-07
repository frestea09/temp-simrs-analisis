@extends('master')
@section('header')
    <h1>Laporan PPI <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4>Periode tanggal: </h4>
        </div>
        <div class="box-body">

            {!! Form::open(['method' => 'POST', 'url' => '/laporan-ppi', 'class' => 'form-hosizontal']) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group{{ $errors->has('tgl_awal') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgl_awal') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tgl_awal', $tga, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('tgl_awal') }}</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai Tanggal</button>
                        </span>
                        {!! Form::text('tgl_akhir', $tgb, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <hr>

            @if (isset($ppis) && $ppis != null)
                <div class="row">
                    <div class="col-md-12">
                        <div class='table-responsive'>
                            <table class="table table-hover table-bordered" id="data">
                                <thead>
                                    <td style="font-weight: bold">No.</td>
                                    <td style="font-weight: bold">NAMA Pasien</td>
                                    <td style="font-weight: bold">NO RM</td>
                                    <td style="font-weight: bold">Lihat</td>
                                </thead>
                                <tbody>
                                    @foreach ($ppis as $ppi)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$ppi->nama}}</td>
                                            <td>{{$ppi->no_rm}}</td>
                                            <td>
                                                <a href="{{url('hais/inap/' . $ppi->registrasi_id)}}" target="_blank"><button type="button"class="btn btn-sm btn-success btn-flat" title="Lihat"><i class="fa fa-eye"></i></button></a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
