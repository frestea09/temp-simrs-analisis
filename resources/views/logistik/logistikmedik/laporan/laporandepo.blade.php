@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Stock Depo</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <form method="POST" class="form-horizontal" id="filterGudang">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="periode" class="col-sm-3 control-label">Periode</label>
                <div class="col-sm-4">
                    <input type="text" name="tga" class="form-control datepicker">
                </div>
                <div class="col-sm-1">
                    s/d
                </div>
                <div class="col-sm-4">
                    <input type="text" name="tgb" class="form-control datepicker">
                </div>
              </div>
              <div class="form-group">
                <label for="jenis_pasien" class="col-sm-3 control-label">Janis Pasien</label>
                <div class="col-sm-9">
                  <select name="jenis_pasien" class="form-control select2" style="width: 100%;">
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="gudang" class="col-sm-3 control-label">Gudang</label>
                <div class="col-sm-9">
                  <select name="gudang" class="form-control select2" style="width: 100%;">
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                  <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                  <input type="submit" name="cetak" class="btn btn-success btn-flat fa-file-pdf" value=" &#xf1c3; CETAK">
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th class="text-center">Masuk</th>
                    <th class="text-center">Keluar</th>
                    <th class="text-center">Saldo</th>
                  </tr>
                </thead>
                <tbody id="viewData">

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
  //getGudang
  {{--  $.ajax({
    url: '/logistikmedik/data-supplier',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(json) {
    $('select[name="supplier"]').empty()
    $.each(json, function(index, val) {
       $('select[name="supplier"]').append('<option value="'+val.supplier+'">'+val.supplier+'</option>')
    });
  });  --}}

</script>
@endsection
