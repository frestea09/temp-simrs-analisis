@extends('master')

@section('header')
  <h1>Logistik - Stok Opname</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form method="POST" action="{{ url('logistikmedik/addOpname') }}" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="periode" class="col-sm-4 control-label">Periode</label>
              <div class="col-sm-8">
                {!! Form::select('periode', $periode, null, ['class' => 'form-control select2']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="tanggalopname" class="col-sm-4 control-label">Tanggal Opname</label>
              <div class="col-sm-8">
                {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="gudang" class="col-sm-4 control-label">Gudang</label>
              <div class="col-sm-8">
                {!! Form::text(null, $gudang->nama, ['class' => 'form-control']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="filter_nama" class="col-sm-4 control-label">Filter Nama Awalan Obat</label>
              <div class="col-sm-8">
                  <select class="form-control select2" name="filter_nama">
                    @php
                        $arr_az = range('A','Z');
                    @endphp
                    @foreach ($arr_az as $item)
                      <option>{{ $item }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label for="kategori" class="col-sm-4 control-label">Kategori</label>
              <div class="col-sm-8">
                {!! Form::select('kategori', $kategori, null, ['class' => 'form-control select2']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="submit" class="col-sm-4 control-label">&nbsp;</label>
              <div class="col-sm-8">
                <input type="button" onclick="tampil()" class="btn btn-success btn-flat fa-file-pdf" value="TAMPILKAN">
              </div>
            </div>
          </div>
        </div>
        <hr/>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Item</th>
                    <th class="text-center">Satuan Item</th>
                    {{-- <th width="120px" class="text-center">Stok Tercatat</th> --}}
                    <th class="text-center">Stok Sebenarnya</th>
                    {{-- <th class="text-center">Keterangan</th> --}}
                  </tr>
                </thead>
                <tbody id="viewData">
                </tbody>
              </table>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-flat" style="position: fixed; bottom: 20px; right: 40%">SIMPAN</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $('.select2').select2();
    function tampil(){
      var kat= $("select[name='kategori']").val(),
          periode = $("select[name='periode']").val();
          abjad = $("select[name='filter_nama']").val();
      $.get("getObat/"+kat+"/"+periode+"/"+abjad, function(resp){
        $("#viewData").html(resp)
      })
    }
  </script>
@endsection