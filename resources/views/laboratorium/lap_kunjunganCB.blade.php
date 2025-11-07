@extends('master')
@section('header')
    <h1>Laboratorium - Laporan Kunjungan Per Cara Bayar<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => '/laboratorium/laporan-kunjungan-cb', 'class' => 'form-horizontal']) !!}

            <div class="row">
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', null, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai Tanggal</button>
                        </span>
                        {!! Form::text('tgb', null, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}"
                                type="button">Layanan</button>
                        </span>
                        {!! Form::select(
                            'pasien_asal',
                            ['TA' => 'Rawat Jalan', 'TG' => 'Rawat Darurat', 'TI' => 'Rawat Inap', '' => 'Semua'],
                            '',
                            ['class' => 'chosen-select datepicker form-control'],
                        ) !!}
                        <small class="text-danger">{{ $errors->first('politipe') }}</small>
                    </div>
                </div> --}}

            </div>
            <br>
            <div class="row">
               
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="btn-group">
                        <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
                        {{-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                            value="EXCEL"> --}}
                    </div>
                </div>

            </div>

            {!! Form::close() !!}
            <hr>
            @isset($kunjungan)
                {{-- <h4 class="text-primary" style="margin-bottom: -10px">Total Pengunjung: {{ $jumlahPengunjung }} | Total Tindakan: {{ $jumlahTindakan }}</h4> --}}
                <div class='table-responsive'>
                    <table class='table-striped table-bordered table-hover table-condensed table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cara Bayar</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kunjungan as $key=>$item)
                                <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item['carabayar']}}</td>
                                <td><b>{{$item['total']}}</b></td>
                                @if (count($item['jenisjkn']) >0)
                                @foreach ($item['jenisjkn'] as $tipe)
                                </tr>
                                    <td></td>
                                    <td>{{$tipe['tipe_jkn']}}</td>
                                    <td>{{$tipe['total']}}</td>
                                    
                                </tr>
                                @endforeach
                                </tr>
                                    <td></td>
                                    <td>Lainnya</td>
                                    <td>{{$item['lainnya']}}</td>
                                    
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>
            @endisset

        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2()
    </script>
@endsection
