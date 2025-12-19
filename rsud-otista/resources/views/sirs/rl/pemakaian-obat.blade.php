@extends('master')
@section('header')
    <h1>Laporan RL 13A Pemakaian Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'rl-pemakaian-obat', 'class' => 'form-hosizontal']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', $tga, [
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
                            <button class="btn btn-default" type="button">s/d Tanggal</button>
                        </span>
                        {!! Form::text('tgb', $tgb, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
                    {{-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                        value=" &#xf1c3; EXCEL"> --}}
                </div>
            </div>
            {!! Form::close() !!}
            <hr>
            {{-- ================================================================================================== --}}
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id="data">
                    <thead>
                        <tr>
                            <th class="text-center" valign="top">No</th>
                            <th valign="top">GOLONGAN OBAT</th>
                            <th class="text-center" valign="top">RAWAT JALAN</th>
                            <th class="text-center" valign="top">IGD</th>
                            <th class="text-center" valign="top">RAWAT INAP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                            <tr>
                                <td>{{$no++}}</td>
                                <td >{{$data['label']}}</td>
                                <td class="text-center">{{$data['count_rj']}}</td>
                                <td class="text-center">{{$data['count_igd']}}</td>
                                <td class="text-center">{{$data['count_inap']}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
