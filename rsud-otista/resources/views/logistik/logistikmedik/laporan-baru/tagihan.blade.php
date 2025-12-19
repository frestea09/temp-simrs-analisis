@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Tagihan</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan/tagihan', 'class'=>'form-horizontal']) !!}
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
              @php
              $sup = App\Logistik\LogistikSupplier::groupBy('nama')->get();
          @endphp
            <div class="form-group">
              <label class="col-md-3 control-label">Supplier</label>
              <div class="input-group col-md-6 date">
                <select name="supplier" class="form-control select2" id="">
                    @if (isset($supplier_cache))
                      <option value="{{ $supplier_cache }}" selected>{{ $supplier_cache}}</option>
                    @else
                      <option value="" selected>Semua</option>
                    @endif
                  @foreach ($sup as $item)
                      <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
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
                    <th>Nama Barang</th>
                    <th>Timestamp</th>
                    <th>Perusahaan</th>
                    <th>Jenis Pembelian</th>
                    <th>No.Faktur</th>
                    <th>Tgl.Faktur</th>
                    <th>Tgl.Jatuh Tempo</th>
                    <th>Jumlah</th>
                    <th>Tgl.Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($data['po']))
                    @foreach ($data['po'] as $key => $d)
                      <tr>
                        <td>{{ baca_obat($d['masterobat_id']) }}</td>
                        <td>{{$d['created_at']}}</td>
                        <td>{{$d['supplier']}}</td>
                        <td>{{baca_carabayar($d['jenis_pembayaran'])}}</td>
                        <td>{{$d['no_faktur']}}</td>
                        <td>{{date('d/m/Y',strtotime($d['tgl_faktur']))}}</td>
                        <td>{{date('d/m/Y',strtotime($d['tgl_jatuh_tempo']))}}</td>
                        <td>{{number_format($d['total_tagihan'])}}</td>
                        <td>{{date('d/m/Y',strtotime($d['tgl_dibayar']))}}</td>
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
