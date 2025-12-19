@extends('master')
@section('header')
  <h1>Log Bed Per Tanggal<small></small></h1>
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
              <label for="tga" class="col-sm-3 control-label">Tanggal Awal</label>
              <div class="col-sm-9">
                <input type="text" name="tgl_awal" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Tanggal Akhir</label>
              <div class="col-sm-9">
                <input type="text" name="tgl_akhir" value="{{ date('d-m-Y') }}" class="form-control datepicker">
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
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  {{-- <th class="text-center" style="vertical-align: middle;">Kode Booking</th>
                  <th class="text-center" style="vertical-align: middle;">Response WS</th> --}}
                  <th class="text-center" style="vertical-align: middle;">Request</th>
                  {{-- <th class="text-center" style="vertical-align: middle;">Url</th> --}}
                  {{-- <th class="text-center" style="vertical-align: middle;">Petugas</th> --}}
                  <th class="text-center" style="vertical-align: middle;">Waktu</th>
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
        url: '/bridgingsep/log-bed',
        type: 'POST',
        dataType: 'json',
        data: $('#formKunjungan').serialize(),
        // data: {
        //   data : ,
        //   _token : $('input[name="_token"]').val(),
        //   _method : 'POST'
        //   },
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
        console.log(data)
        if(data == null){
          $('.overlay').addClass('hidden')
          return alert('Gagal mengambil data, periksa jaringan')
        }

        // console.log(data);
        if (data.length === 0) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          $('tbody').append('<tr> <td colspan="4">Tidak ada data</td> </tr>')
        }
        // return
        if (data.length > 0) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          
          $('.poli').removeClass('hidden')
          $('.kelasRawat').addClass('hidden')
          $.each(data, function(index, val) {
            if(val.response == '{"metadata":{"code":208,"message":"Terdapat duplikasi Kode Booking"}}'){
              val.response = '{"metadata":{"code":200,"message":"Ok."}}';
            }
            $('tbody').append('<tr> <td>'+(index+1)+'</td><td style="font-size:10px !important;"><a href="/bridgingsep/log-bed/'+val.id+'" class="btn btn-xs btn-success">Lihat Log</a></td><td>'+val.created_at+'</td></tr>')
          });
        }
      });
    }


  </script>
@endsection
