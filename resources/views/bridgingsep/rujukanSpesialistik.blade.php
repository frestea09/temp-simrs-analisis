@extends('master')
@section('header')
  <h1>Rujukan Spesialistik<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
          <form method="POST" class="form-horizontal" id="formKunjungan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="tglSep" class="col-sm-3 control-label">Tanggal rujukan</label>
              <div class="col-sm-9">
                <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div> 
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">Kode PPK Rujukan </label>
              <div class="col-sm-9">
                <input type="text" name="nomor" class="form-control" style="width: 100%">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="tampilkanHistoriSEP()">TAMPILKAN</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan hidden">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Kode Spesialis</th>
                  <th class="text-center" style="vertical-align: middle;">Nama Spesialis</th>
                  <th class="text-center" style="vertical-align: middle;">Kapasitas</th>
                  <th class="text-center" style="vertical-align: middle;">Jml. Rujukan</th>
                  <th class="text-center" style="vertical-align: middle;">Persentase</th>
                </tr>
              </thead>
              <tbody>

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

@include('bridgingsep.form')

@endsection

@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $('.select2').select2();

    function tampilkanHistoriSEP() {
      $('.respon').html('');
      $.ajax({
        url: '/bridgingsep/rujukan-spesialistik',
        type: 'POST',
        dataType: 'json',
        // data: $('#formKunjungan').serialie(),
        data: {
          data : LZString.compressToBase64($('#formKunjungan').serialize()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
          },
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
           $('.overlay').addClass('hidden')
        }
      })
      .done(function(res) {
        // var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(res)
        // console.log(data);
        if (data[0].metaData.code == '201') {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          $('tbody').append('<tr> <td colspan="8">'+data[0].metaData.message+'</td> </tr>')
        }
        if (data[0].metaData.code == '200') {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          $.each(data[1].list, function(index, val) {
            $('tbody').append('<tr> <td>'+val.kodeSpesialis+'</td>  <td>'+val.namaSpesialis+'</td> <td>'+val.kapasitas+'</td>  <td class="text-center">'+val.jumlahRujukan+'</td> <td>'+val.persentase+'</td></tr>')
          }); 
        }
      });
    }


  </script>
@endsection
