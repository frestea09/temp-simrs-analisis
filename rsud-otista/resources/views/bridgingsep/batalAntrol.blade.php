@extends('master')
@section('header')
  <h1>List Task ID<small></small></h1>
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
              <label for="tgb" class="col-sm-3 control-label">Kode booking</label>
              <div class="col-sm-9">
                <input name="kodebooking" class="form-control" id="">
              </div>
            </div>  
            <div class="form-group">
              <label for="tgb" class="col-sm-3 control-label">Alasan</label>
              <div class="col-sm-9">
                <input name="alasan" class="form-control" id="">
              </div>
            </div>  
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="tampilkanHistoriSEP()">Kirim</button>
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
                  <th class="text-center" style="vertical-align: middle;">Kode Booking</th>
                  <th class="text-center" style="vertical-align: middle;">Task Name</th>
                  <th class="text-center" style="vertical-align: middle;">Task ID</th>
                  <th class="text-center" style="vertical-align: middle;">Waktu RS</th>
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
        url: '/bridgingsep/batal-antrol',
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
        console.log(data)
        // return
        if(data[0] == null){
          $('.overlay').addClass('hidden')
          return alert('Gagal mengambil data, periksa jaringan')
        }

        // console.log(data);
        // if (data[0].metadata.code == 204) {
        //   $('.dataKunjungan').removeClass('hidden')
        //   $('tbody').empty()
        //   $('tbody').append('<tr> <td colspan="8">'+data[0].metadata.message+'</td> </tr>')
        // }
        if (data[0].metadata.code == 200) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          return alert('Berhasil Batalkan Antrol')
          // $('.poli').removeClass('hidden')
          // $('.kelasRawat').addClass('hidden')
          // $.each(data[1], function(index, val) {
          //   $('tbody').append('<tr> <td>'+val.kodebooking+'</td><td>'+val.taskname+'</td> <td>'+val.taskid+'</td> <td>'+val.wakturs+'</td>  <td>'+val.waktu+'</td></tr>')
          // });
        }else{
          return alert('Berhasil Batalkan Antrol')
          // return alert(data[0].metadata.message)
        }
      });
    }


  </script>
@endsection
