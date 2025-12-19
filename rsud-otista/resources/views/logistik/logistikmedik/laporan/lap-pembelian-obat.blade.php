@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Pembelian</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan/pembelian-obat', 'class'=>'form-horizontal']) !!}
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
                <label class="col-md-3 control-label">Supplier</label>
                <div class="input-group col-md-6">
                  <select name="supplier" id="" class="form-control select2">
                      <option value="" {{ $supp == '' ? 'selected' : '' }}>[SEMUA]</option>
                    @foreach ($supplier as $id => $nama)
                      <option value="{{ $nama }}" {{ $supp == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <input type="submit" name="type" class="btn btn-primary btn-flat" value="LANJUT">
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
                    <th>No Faktur</th>
                    <th>Tanggal Faktur</th>
                    <th>Supplier</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                    <th>Harga Beli Satuan</th>
                    <th>Diskon Rp.</th>
                    <th>Jumlah Pembelian</th>
                    <th>PPN %</th>
                    <th>PPN Rp.</th>
                    <th>Jenis Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($po))
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($po as $key => $items)
                      @php
                        $rowspan = $items->count();
                      @endphp
                      @foreach ($items as $st)
                        <tr>
                          @if ($loop->first)
                            
                          <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: middle;">{{ $no++ }}</td>
                          <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: middle;">{{$st->no_faktur}}</td>
                          <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: middle;">{{$st->tgl_faktur}}</td>
                          @endif
                          <td>{{$st->supplier}}</td>
                          <td>{{@$st->po ? @$st->po->kode_barang : '-'}}</td>
                          <td>{{$st->nama_barang}}</td>
                          <td>{{@$st->po ? baca_satuan_beli($st->po->satuan) : '-'}}</td>
                          <td>{{@$st->po ? $st->po->jumlah : '-'}}</td>
                          <td>{{@$st->po ? 'Rp. ' . number_format($st->po->harga) : ''}}</td>
                          <td>{{@$st->po ? 'Rp. ' . number_format($st->po->diskon_rupiah): ''}}</td>
                          <td>{{@$st->po ? 'Rp. ' . number_format($st->po->totalHarga) : ''}}</td>
                          <td>{{$st->po->jml_ppn ?? 0}}%</td>
                          <td>
                            @php
                              $totalPPN = @$st->po ? $st->po->totalHarga * ($st->po->jml_ppn / 100) : 0;
                            @endphp
                            {{'Rp. ' . number_format($totalPPN)}}
                          </td>
                          <td>{{$st->jenis_pembayaran == 1 ? 'Cash' : 'Faktur'}}</td>
                        </tr>
                      @endforeach
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
