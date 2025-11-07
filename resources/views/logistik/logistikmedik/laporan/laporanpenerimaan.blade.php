@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Penerimaan</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan-penerimaan', 'class'=>'form-horizontal']) !!}
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-md-3 control-label">Tanggal Mulai</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tgl_awal" class="form-control pull-right datepicker" id="tgl_mulai" value="{{ !empty($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '' }}">
                  <small class="text-danger">{{ $errors->first('tgl_awal') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Tanggal Akhir</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tgl_akhir" class="form-control pull-right datepicker" id="tgl_akhir" value="{{ !empty($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : '' }}">
                  <small class="text-danger">{{ $errors->first('tgl_akhir') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                  <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                  <input type="submit" name="pdf" class="btn btn-info btn-flat" value="PDF">
                </div>
              </div>
            </div>
          </div>
        {!! Form::close() !!}
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" id="data">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Faktur</th>
                    <th>Tanggal Penerimaan</th>
                    <th>Obat</th>
                    <th>Jumlah Terima</th>
                    <th>Supplier</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($penerimaan))
                    @foreach ($penerimaan as $key => $d)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->no_faktur }}</td>
                        <td>{{ $d->tanggal_penerimaan }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->terima }}</td>
                        <td>{{ $d->supplier_id }}</td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

  $('.select2').select2()

</script>
@endsection
