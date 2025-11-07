@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Pengeluaran</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan/pengeluaran', 'class'=>'form-horizontal']) !!}
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-md-3 control-label">Tanggal Mulai</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input autocomplete="off" type="text" name="tga" class="form-control pull-right datepicker" id="tga" value="{{ !empty($_POST['tga']) ? $_POST['tga'] : '' }}">
                  <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Tanggal Akhir</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input autocomplete="off" type="text" name="tgb" class="form-control pull-right datepicker" id="tgb" value="{{ !empty($_POST['tgb']) ? $_POST['tgb'] : '' }}">
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                  <input type="submit" name="type" onclick="$('form').attr('target', '_blank');" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                  {{-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                  <input type="submit" name="pdf" class="btn btn-info btn-flat" value="PDF"> --}}
                </div>
              </div>
            </div>
          </div>
        {!! Form::close() !!}
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" id="data" style="font-size: 12px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Gudang Tujuan</th>
                    <th>Satuan Jenis</th>
                    <th>Jumlah Pengeluaran</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($data['po']))
                    @php
                        $no = 0;
                        $obat = App\Masterobat::find(@$st->masterobat_id);
                    @endphp
                    @foreach ($data['po'] as $key => $st)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ baca_obat($st->masterobat_id) }}</td>
                        <td>{{ baca_gudang_logistik($st->gudang_asal) }}</td>
                        <td>{{ @$obat->satuanbeli->nama }}</td>
                        <td>{{ @$st->terkirim }}</td>
                        <td>{{ @$st->created_at }}</td>
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
