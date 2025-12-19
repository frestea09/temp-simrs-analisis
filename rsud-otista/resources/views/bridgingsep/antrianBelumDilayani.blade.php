@extends('master')
@section('header')
  <h1>Antrian Belum Dilayani<small></small></h1>
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
              <label for="tgb" class="col-sm-3 control-label">Tgl.Pelayanan</label>
              <div class="col-sm-9">
                <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control" readonly>
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
      <div class="row dataKunjungan hidden" style="font-size:12px">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                {{-- <tr>
                  <th class="text-center" style="vertical-align: middle;" rowspan="2" style="max-width:5% !important;">No</th>
                  <th class="text-center" style="vertical-align: middle;" rowspan="2" style="max-width:5% !important;">Kontrol</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="2">Nama</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="2">Poli</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="3">Nomor</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="3">Tanggal</th>
                </tr> --}}
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Booking</th>
                  <th class="text-center" style="vertical-align: middle;">RM</th>
                  {{-- <th class="text-center" style="vertical-align: middle;">Dokter</th> --}}
                  <th class="text-center" style="vertical-align: middle;">Praktek</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">No.Antrean</th>
                  <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                  <th class="text-center" style="vertical-align: middle;">Sumber</th>
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
        url: '/bridgingsep/antrian-belum-dilayani',
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
        console.log(data = JSON.parse(res))
        
        // console.log(data)
        if(data[0] == null){
          $('.overlay').addClass('hidden')
          return alert('Gagal mengambil data, periksa jaringan')
        }

        // console.log(data);
        if (data[0].metadata.code !== 200) {
          return alert(data[0].metadata.message)
        }
        if (data[0].metadata.code == 200) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          
          $('.poli').removeClass('hidden')
          $('.kelasRawat').addClass('hidden')
          $.each(data[1], function(index, val) {
            $('tbody').append('<tr> <td>'+(index + 1)+'</td><td>'+val.kodebooking+'</td> <td>'+val.norekammedis+'</td><td>'+val.jampraktek+'</td><td>'+val.kodepoli+'</td><td>'+val.noantrean+'</td><td>'+val.tanggal+'</td><td>'+val.sumberdata+'</td></tr>')
          });
        }
      });
    }


  </script>
@endsection
