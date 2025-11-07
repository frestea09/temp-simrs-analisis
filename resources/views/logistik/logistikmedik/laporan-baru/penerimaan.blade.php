@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Penerimaan</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/laporan/penerimaan', 'class'=>'form-horizontal']) !!}
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
                {{-- <div class="form-group">
                  <label class="col-md-3 control-label">Supplier</label>
                    <select name="" class="form-control select2" id="">
                        @foreach ($sup as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="form-group">
                  <label class="col-md-3 control-label">Supplier</label>
                  <div class="input-group col-md-6 date">
                    {{-- <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div> --}}
                  
                    <select name="supplier" class="form-control select2" id="">
                   
                    
                      <option value="{{ $supplier }}" selected>{{ $supplier}}</option>
                   
                      @foreach ($sup as $item)
                          <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Tanggal Cetak SP</label>
                  <div class="input-group col-md-6">
                    <input autocomplete="off" type="text" name="tanggal_cetak_sp" class="form-control pull-right datepicker" id="tanggal_cetak_sp" value="{{ !empty($_POST['tanggal_cetak_sp']) ? $_POST['tanggal_cetak_sp'] : '' }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">No SP</label>
                  <div class="input-group col-md-6">
                    <input autocomplete="off" type="text" name="no_sp" class="form-control pull-right" id="no_sp" value="{{ !empty($_POST['no_sp']) ? $_POST['no_sp'] : '' }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">No Usulan Cetak SP</label>
                  <div class="input-group col-md-6">
                    <input autocomplete="off" type="text" name="no_usulan_cetak_sp" class="form-control pull-right" id="no_usulan_cetak_sp" value="{{ !empty($_POST['no_usulan_cetak_sp']) ? $_POST['no_usulan_cetak_sp'] : '' }}">
                  </div>
                </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9" style="padding: 0;">
                  <input type="submit" name="type" class="btn btn-primary btn-flat" onclick="$('form').attr('target', '');" value="LANJUT">
                  <input type="submit" name="type" onclick="$('form').attr('target', '');" class="btn btn-danger btn-flat" value="CETAK BA">
                  <input type="submit" name="type" onclick="$('form').attr('target', '');" class="btn btn-danger btn-flat" value="CETAK SP">
                  <input type="submit" name="type" onclick="$('form').attr('target', '');" class="btn btn-danger btn-flat" value="CETAK SPPBJ">
                  <input type="submit" name="type" onclick="$('form').attr('target', '');" class="btn btn-danger btn-flat" value="CETAK">
                  <input type="submit" name="type" onclick="$('form').attr('target', '_blank');" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                  {{-- <input type="submit" name="pdf" class="btn btn-info btn-flat" value="PDF"> --}}
                </div>
              </div>
            </div>
          </div>
        {!! Form::close() !!}
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" id="data" style="font-size:12px;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Faktur</th>
                    <th>Supplier</th>
                    <th>Tanggal Penerimaan</th>
                    <th>Obat</th>
                    <th>PPN %</th>
                    <th>PPN</th>
                    <th>Diskon</th>
                    <th>Jumlah Terima</th>
                    <th>Harga Barang</th>
                  </tr>
                </thead>
                <tbody>
              {{-- @php
                 dd($data['po']);
              @endphp --}}
                  @if (!empty($data['po']))
                    @php
                      $no = 1;
                    @endphp
                    @foreach ($data['po'] as $key => $items)
                      @php
                          $rowspan = $items->count();
                          $totalFaktur = 0;
                      @endphp
                      @foreach($items as $d)
                      @php
                          $totalFaktur += $d->total_desimal ?? 0;
                      @endphp
                      <tr>
                        @if($loop->first)
                        <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: middle;">{{ $no++ }}</td>
                        <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: middle;">{{ @$d->no_faktur }}</td>
                        <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: middle;">{{ $d->supplier }}</td>
                        @endif
                        <td>{{ $d->created_at }}</td>
                        <td>{{ @$d->barang->nama }}</td>
                        <td>{{ $d->jml_ppn ?? 0 }}%</td>
                        <td>
                          @php
                            $totalPPN = $d->totalHarga * ($d->jml_ppn / 100)
                          @endphp
                          {{'Rp. ' . number_format($totalPPN)}}
                        </td>
                        <td>{{ @$d->diskon_persen }}%</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp. {{ number_format($d->total_desimal,2,',','.') }}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="9" class="text-right" style="font-weight: bold;">Total Harga Faktur</td>
                        <td>{{ @$totalFaktur }}</td>
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
  $(".skin-blue").addClass( "sidebar-collapse" );
</script>
@endsection
