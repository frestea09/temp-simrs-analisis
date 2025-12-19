@extends('master')
@section('header')
  <h1>Histori Pelayanan Peserta<small></small></h1>
@endsection

@section('content')
<style>
  .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top{
    top: 70px !important;
  }
  </style>
    <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
          <form method="POST" class="form-horizontal" id="formKunjungan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="tglSep" class="col-sm-3 control-label">Nomor Kartu</label>
              <div class="col-sm-9">
                <input type="text" name="noKartu" value="{{@request()->get('nokartu')}}" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="tglSep" class="col-sm-3 control-label">Tanggal Awal</label>
              <div class="col-sm-9">
                <input type="text" name="tga" value="{{ date('d-m-Y') }}"  class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="tglSep" class="col-sm-3 control-label">Tanggal Akhir</label>
              <div class="col-sm-9">
                <input type="text" name="tgb" value="{{ date('d-m-Y') }}"  class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="tampilkanHistoriPelayanan()">TAMPILKAN</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan hidden">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>No. Rujukan</th>
                  <th>No. SEP</th>
                  <th>Jns Layanan</th>
                  <th>Klinik</th>
                  <th>Tgl SEP</th>
                  <th>Tgl Plg SEP</th>
                  <th>PPK Pelayanan</th>
                  <th>Diagnosa</th>
                </tr>
              </thead>
              <tbody class="viewDataHistori">

              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
      {{-- Loading State --}}
      <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    <div class="box-footer">

    </div>
  </div>



@endsection

@section('script')
  <script type="text/javascript">
    $('.select2').select2();

    function tampilkanHistoriPelayanan() {
      $('.overlay').removeClass('hidden')
      $('.respon').html('')
      $.ajax({
        url: '/bridgingsep/histori-kunjungan',
        type: 'POST',
        dataType: 'json',
        data: $('#formKunjungan').serialize(),
      })
      .done(function(res) {
        $('.overlay').addClass('hidden')
        data = JSON.parse(res)

        if (data[0].metaData.code !== "200") {
          return alert(data[0].metaData.message)
        }
        
        $('.dataKunjungan').removeClass('hidden')
        $('.viewDataHistori').empty()
        $.each(data[1].histori, function(index, val) {
           $('.viewDataHistori').append('<tr> <td>'+(index + 1)+'</td> <td>'+val.namaPeserta+'</td> <td>'+val.noRujukan+'</td> <td>'+val.noSep+'</td> <td>'+val.jnsPelayanan+'</td> <td>'+val.poli+'</td> <td>'+val.tglSep+'</td> <td>'+val.tglPlgSep+'</td> <td>'+val.ppkPelayanan+'</td> <td>'+val.diagnosa+'</td> </tr>')
        });

      })
      .fail(function() {

      });

    }
  </script>
@endsection
