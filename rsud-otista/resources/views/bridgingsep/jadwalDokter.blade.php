@extends('master')
@section('header')
  <h1>Jadwal Dokter<small></small></h1>
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
              <label for="tglSep" class="col-sm-3 control-label">Rencana Kontrol</label>
              <div class="col-sm-9">
                <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="jenisKontrol" class="col-sm-3 control-label">Jenis Kontrol</label>
              <div class="col-sm-9">
                <select name="jenisKontrol" class="form-control select2" style="width: 100%">
                  <option value="1">SPRI</option>
                  <option value="2">Rencana Kontrol</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">Poli</label>
              <div class="col-sm-9">
                  <select name="poli" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $item)
                      <option value="{{$item->bpjs}}">{{$item->nama}}</option>
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
      <div class="row dataKunjungan hidden">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Kode Dokter</th>
                  <th class="text-center" style="vertical-align: middle;">Nama Dokter</th>
                  <th class="text-center" style="vertical-align: middle;">Jadwal Praktek</th>
                  <th class="text-center" style="vertical-align: middle;">Kapasitas</th>
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
        url: '/bridgingsep/jadwal-dokter',
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
        if (data[0].metaData.code == 201) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          $('tbody').append('<tr> <td colspan="8">'+data[0].metaData.message+'</td> </tr>')
        }
        if (data[0].metaData.code == 200) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          if ($('select[name="jenisPelayanan"]').val() == 1) {
            $('.poli').addClass('hidden')
            $('.kelasRawat').removeClass('hidden')
            $.each(data[1].list, function(index, val) {
              $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodeDokter+'</td> <td>'+val.namaDokter+'</td>  <td class="text-center">'+val.jadwalPraktek+'</td> <td>'+val.kapasitas+'</td></tr>')
             });
          } else {
            $('.poli').removeClass('hidden')
            $('.kelasRawat').addClass('hidden')
            $.each(data[1].list, function(index, val) {
              $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodeDokter+'</td> <td>'+val.namaDokter+'</td>  <td class="text-center">'+val.jadwalPraktek+'</td> <td>'+val.kapasitas+'</td></tr>')
            });
          }
        }
      });
    }


  </script>
@endsection
