@extends('master')

@section('header')
  <h1>Logistik <small>Kartu Stok</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <form method="POST" class="form-horizontal" action="{{ url('logistikmedik/kartustok/gelobalStok') }}" id="filterGudang">
          {{ csrf_field() }}
            <div class="col-sm-6">
              {{--  <div class="form-group">
                <label for="gudang" class="col-sm-3 control-label">Gudang</label>
                <div class="col-sm-9">
                  <select class="form-control select2" name="gudang"  style="width: 275px;">
                    @foreach ($gudang as $key => $d)
                      @if (!empty($_POST['gudang']) && $_POST['gudang'] == $d->nama)
                        <option value="{{ $d->nama }}" selected>{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->nama }}" >{{ $d->nama }}</option>
                      @endif
                    @endforeach
                </select>
                </div>
              </div>  --}}
              {{-- <div class="form-group">
                  <label for="periode" class="col-sm-3 control-label">Periode</label>
                  <div class="col-sm-4 {{ $errors->has('tgl_awal') ? 'has-error' :'' }}">
                      <input type="text" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : NULL }}" autocomplete="off" class="form-control datepicker">
                  </div>
                  <div class="col-sm-1 text-center">
                      s/d
                  </div>
                  <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                      <input type="text" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : NULL }}"  autocomplete="off" class="form-control datepicker">
                  </div>
              </div> --}}
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="masterobat_id" class="col-sm-3 control-label">Obat</label>
                <div class="col-sm-9">
                  <select name="masterobat_id" id="" class="form-control select2">
                    <option value="all">-- SEMUA --</option>
                    @foreach ($obat as $item)
                      <option value="{{$item['id']}}">{{$item['nama']}}</option>
                    @endforeach
                  </select>
                  {{-- {!! Form::select('masterobat_id', $obat, null, ['class' => 'form-control select2']) !!} --}}
                </div>
              </div>
              <div class="form-group">
                <label for="submit" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <button type="button" onclick="proses()" class="btn btn-primary btn-flat">TAMPILKAN</button>
                  <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL"/>
                  <input type="submit" name="cetak" class="btn btn-warning btn-flat" value="CETAK"/>
                </div>
              </div>
            </div>
        </form>
        <div class="row"> 
          <div class="col-sm-12">
            <div class="overlay hidden">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="table-responsive" style="height:500px;">
              <table class="table table-hover table-bordered table-condensed">
                <thead style="position: sticky;top: 0;background: wheat;">
                  <tr>
                    <th>No</th>
                    <th>Nama.Brg</th>
                    <th class="text-center">Masuk</th>
                    <th>Gudang Pusat</th>
                    <th class="text-center">Rajal</th>
                    <th class="text-center">Ranap</th>
                    <th class="text-center">UGD</th>
                    {{-- <th class="text-center">KPR</th> --}}
                    <th class="text-center">IBS</th>
                    <th class="text-center">Total</th>
                    <th>Keterangan</th>
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
  $('.select2').select2();

  function proses() {
    $('.overlay').removeClass('hidden')
    $('#viewData').empty()
    $.ajax({
      url: '/logistikmedik/kartustok/gelobalStok',
      type: 'POST',
      dataType: 'json',
      data: $('#filterGudang').serialize(),
    })
    .done(function(json) {
      $('.overlay').addClass('hidden')
      $('#viewData').empty()
      // console.log()
      if(!json.sukses){
        return alert(json.data)
      }

      $.each(json.data, function(index, val) {
        // console.log(val);
         $('#viewData').append('<tr><td>'+(index+1)+'</td><td>'+(val.nama)+'</td><td class="text-center">'+val.masuk+'</td><td class="text-center">'+val.gudang_pusat+'</td><td class="text-center">'+val.rajal+'</td><td class="text-center">'+val.ranap+'</td><td class="text-center">'+val.ugd+'</td><td class="text-center">'+val.ibs+'</td><td class="text-center">'+val.total+'</td><td class="text-center">'+val.keterangan+'</td></tr>')
      });

    });

  }

</script>
@endsection
