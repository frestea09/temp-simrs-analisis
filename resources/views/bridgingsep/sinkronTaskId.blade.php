@extends('master')
@section('header')
  <h1>Sinkron Task Id<small></small></h1>
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
              <label for="poli" class="col-sm-3 control-label">No.Antrian</label>
              <div class="col-sm-9">
                  <input type="text" name="nomor" class="form-control" style="width: 100%">
              </div>
            </div>
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">Tgl. Periksa</label>
              <div class="col-sm-9">
                  <input type="date" name="tglperiksa" value="{{date('Y-m-d')}}" class="form-control" style="width: 100%">
                  {{-- <small for=""><i>Jika jenis kontrol = SPRI, maka diisi nomor kartu; jika jenis kontrol = Rencana Kontrol, maka diisi nomor SEP</i></small> --}}
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
                  <th class="text-center" style="vertical-align: middle;">No.Rujukan</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Tgl. Periksa</th>
                  <th class="text-center" style="vertical-align: middle;">-</th>
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
        url: '/bridgingsep/sinkron-taskid',
        type: 'POST',
        dataType: 'json',
        data: $('#formKunjungan').serialize(),
        // data: {
        //   data : $('#formKunjungan').serialize(),
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
        // data = JSON.parse(res)
        data = res
        console.log(data)
        // return
        // if(data[0] == null){
        //   $('.overlay').addClass('hidden')
        //   return alert('Gagal mengambil data, periksa jaringan')
        // }

        // console.log(data);
        // if (data.code !== '200') {
        //   return alert(data[0].metaData.message)
        //   // $('.dataKunjungan').removeClass('hidden')
        //   // $('tbody').empty()
        //   // $('tbody').append('<tr> <td colspan="8">'+data[0].metaData.message+'</td> </tr>')
        // }
        if (data.code == '200') {
          $('.overlay').addClass('hidden')
          $('.dataKunjungan').removeClass('hidden')
          return alert(data.message)
          $('tbody').empty()

          // $('.poli').removeClass('hidden')
          // $('.kelasRawat').addClass('hidden')
          // $.each(data[1].list, function(index, val) {
            $('tbody').append('<tr><td>'+data.message.no_rujukan+'</td> <td>'+data.message.nama+'</td> <td>'+data.message.tglperiksa+'</td>  <td class="text-center"><a style="background-color:red;border:1px solid red;" class="btn btn-success btn-sm" href="/bridgingsep/hapus-antrol-rujukan/'+data.message.no_rujukan+'/'+data.message.tglperiksa+'">HAPUS <span class="fa fa-trash"></span></a></td></tr>')
          // });
        }else{
          return alert(data.message)
        }
      });
    }


  </script>
@endsection
