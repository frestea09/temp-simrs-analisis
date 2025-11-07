@extends('master')
@section('header')
  <h1>Rujukan Khusus<small></small></h1>
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
              <label for="tgb" class="col-sm-3 control-label">Bulan</label>
              <div class="col-sm-9">
                <select name="bln" class="form-control" id="">
                  @for ($i = 1; $i <= 12; $i++)
                      <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </div>
            </div> 
            <div class="form-group">
              <label for="tgb" class="col-sm-3 control-label">Tahun</label>
              <div class="col-sm-9">
                <select name="thn" class="form-control" id="">
                  @php
                      $years = range(date('Y'), 2018);
                  @endphp
                  @foreach ($years as $item)
                    <option value="{{$item}}">{{$item}}</option>
                  @endforeach
                </select>
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
                  <th class="text-center" style="vertical-align: middle;">No.Rujuk</th>
                  <th class="text-center" style="vertical-align: middle;">No.KPsien</th>
                  <th class="text-center" style="vertical-align: middle;">Pasien</th>
                  <th class="text-center" style="vertical-align: middle;">Diag.PPK</th>
                  <th class="text-center" style="vertical-align: middle;">Tgl.Rjk.Awal</th>
                  <th class="text-center" style="vertical-align: middle;">Tgl.Rjk.Akhir</th>
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
        url: '/bridgingsep/rujukan-khusus',
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
        if(data[0] == null){
          $('.overlay').addClass('hidden')
          return alert('Gagal mengambil data, periksa jaringan')
        }

        // console.log(data);
        if (data[0].metaData.code !== 200) {
          return alert(data[0].metaData.message)
          // $('.dataKunjungan').removeClass('hidden')
          // $('tbody').empty()
          // $('tbody').append('<tr> <td colspan="8">'+data[0].metaData.message+'</td> </tr>')
        }
        if (data[0].metaData.code == 200) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          
          $('.poli').removeClass('hidden')
          $('.kelasRawat').addClass('hidden')
          $.each(data[1].rujukan, function(index, val) {
            $('tbody').append('<tr> <td>'+(index + 1)+'</td><td>'+val.norujukan+'</td> <td>'+val.nokapst+'</td> <td>'+val.nmpst+'</td> <td>'+val.diagppk+'</td> <td>'+val.tglrujukan_awal+'</td><td>'+val.tglrujukan_berakhir+'</td></tr>')
          });
        }
      });
    }


  </script>
@endsection
