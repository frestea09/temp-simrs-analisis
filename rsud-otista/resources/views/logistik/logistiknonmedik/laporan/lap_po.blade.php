@extends('master')
@section('header')
  <h1>Laporan - PO<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        <h4>Laporan PO</h4>
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'logistiknonmedik/laporan-po', 'class'=>'form-horizontal']) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="periode" class="col-sm-3 control-label">Periode</label>
                                <div class="col-sm-4 {{ $errors->has('tgl_awal') ? 'has-error' :'' }}">
                                    <input type="text" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : NULL }}" class="form-control datepicker">
                                </div>
                                <div class="col-sm-1 text-center">
                                    s/d
                                </div>
                                <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                                    <input type="text" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : NULL }}" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="VIEW">
                                <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                                <input type="submit" name="pdf" class="btn btn-warning btn-flat fa-file-excel-o" value=" &#xf1c3; PDF">
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
        <h3 class="box-title">List Po</h3>
        <br>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data" border="1">
                    <thead>
                    <tr>
                        <th class="text-center">No PO</th>
                        <th class="text-center">Tanggal Po</th>
                        <th class="text-center">Jenis Pengadaan</th>
                        <th class="text-center">supplier</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (!empty($po))
                            @foreach ($po as $key => $d)
                            <tr>
                                <td>{{ $d->no_po }}</td>
                                <td>{{ $d->tanggal }}</td>
                                <td>{{ $d->jenis_pengadaan }}</td>
                                <td>{{ $d->supplier }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
@endsection
