@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Tagihan</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan-tagihan', 'class'=>'form-horizontal']) !!}
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
                <label class="col-md-3 control-label">Supplier</label>
                <div class="input-group col-md-6 date">
                  <div class="input-group-addon">
                    <i class="fa fa-file"></i>
                  </div>
                  <select class="form-control select2" name="supplier_id"  style="width: 250px;">
                      {{-- <option value="">[Semua]</option> --}}
                      @foreach (\App\Logistik\LogistikSupplier::all() as $key => $d)
                        @if (!empty($_POST['supplier_id']) && $_POST['supplier_id'] == $d->id)
                          <option value="{{ $d->nama }}" selected>{{ $d->nama }}</option>
                        @else
                          <option value="{{ $d->nama }}" >{{ $d->nama }}</option>
                        @endif
                      @endforeach
                  </select>
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
              <table class="table table-striped" id="data">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Obat</th>
                    <th>Terima</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                    <th>PPn</th>
                    <th>Diskon</th>
                    <th>Total Tagihan</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($penerimaan))
                    @foreach ($penerimaan as $key => $d)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->supplier_id }}</td>
                        <td>{{ $d->tanggal_po }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->terima}}</td>
                        <td>{{ number_format($d->hna) }}</td>
                        <td>{{ number_format($d->total_hna) }}</td>
                        <td>{{ number_format($d->ppn) }}</td>
                        <td>{{ !empty(number_format($d->diskon_rupiah)) ? $d->diskon_persen : number_format($d->diskon_rupiah) }}</td>
                        <td>{{ number_format($d->harga_jual) }}</td>
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
