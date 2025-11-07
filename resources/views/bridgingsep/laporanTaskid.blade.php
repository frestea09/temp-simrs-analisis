@extends('master')
@section('header')
  <h1>Laporan Task ID per tanggal</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <p>
          <span style="color:red">*</span> Harap tidak close halaman saat menampikan data, karena data langsung diambil dari BPJS, pengambilan data bisa berlangsung <b>1 menit atau lebih</b> , tergantung jumlah pasien per tanggal tersebut
        </p>
        <div class="col-sm-6">
          <form method="POST" class="form-horizontal" action="{{url('/bridgingsep/laporan-taskid')}}" id="formKunjungan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Tanggal</label>
              <div class="col-sm-9">
                <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Sampai tgl</label>
              <div class="col-sm-9">
                <input type="text" name="tgl_akhir" value="{{ date('d-m-Y') }}" class="form-control datepicker" required>
              </div>
            </div>
            <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <select name="status" id="" class="form-control">
                  <option value="">Semua</option>
                  <option value="200">200</option>
                  <option value="201">201</option>
                </select>
                
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" class="btn btn-success btn-flat">EXCEL</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      {{-- VIEW DATA --}}
      @if (count($data_antrian) > 0)
      <div class="row dataKunjungan" style="font-size:12px">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Kode Booking</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 1</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 2</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 3</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 4</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 5</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 6</th>
                  <th class="text-center" style="vertical-align: middle;">TaskID 7</th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach ($data_antrian as $key=>$item)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$item['nomorantrian']}}</td>
                      <td>{{$item['poli']}}</td>
                      @foreach ($item['data'] as $taskid)
                          <td>{{$taskid['']}}</td>
                      @endforeach
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>    
      @endif

      

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
        url: '/bridgingsep/log-antrian',
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
            $('tbody').append('<tr> <td>'+(index+1)+'</td><td>'+val.nomorantrian+'</td><td>'+val.response+'</td> <td style="font-size:10px !important;">'+val.request+'</td><td>'+val.url+'</td><td>'+val.penginput+'</td><td>'+val.created_at+'</td></tr>')
          });
        }
      });
    }


  </script>
@endsection
