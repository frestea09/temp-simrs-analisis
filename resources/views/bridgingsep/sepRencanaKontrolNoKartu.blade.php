@extends('master')
@section('header')
  <h1>Data Nomor Surat Kontrol Berdasarkan No Kartu<small></small></h1>
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
              <label for="tgb" class="col-sm-3 control-label">No. Kartu</label>
              <div class="col-sm-9">
                <input name="no_kartu" class="form-control" id="" type="text">
              </div>
            </div> 
            <div class="form-group">
              <label for="tgb" class="col-sm-3 control-label">Bulan</label>
              <div class="col-sm-9">
                <select name="bln" class="form-control" id="">
                  @for ($i = 1; $i <= 12; $i++)
                      <option value="{{$i}}" {{date('m') == $i ? 'selected':'' }}>{{$i}}</option>
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
              <label for="jenisKontrol" class="col-sm-3 control-label">Jenis Kontrol</label>
              <div class="col-sm-9">
                <select name="jenisKontrol" class="form-control select2" style="width: 100%">
                  <option value="1">Tgl. Entri</option>
                  <option value="2">Tgl. Rencana Kontrol</option>
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
                  <th class="text-center" style="vertical-align: middle;" rowspan="2" style="max-width:5% !important;">No</th>
                  <th class="text-center" style="vertical-align: middle;" rowspan="2" style="max-width:5% !important;">Kontrol</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="2">Nama</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="2">Poli</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="3">Nomor</th>
                  <th class="text-center" style="vertical-align: middle;" colspan="3">Tanggal</th>
                </tr>
                <tr>
                  {{-- <th class="text-center" style="vertical-align: middle;">No</th> --}}
                  <th class="text-center" style="vertical-align: middle;">Pasien</th>
                  <th class="text-center" style="vertical-align: middle;">Dokter</th>
                  <th class="text-center" style="vertical-align: middle;">Asal</th>
                  <th class="text-center" style="vertical-align: middle;">Tujuan</th>
                  <th class="text-center" style="vertical-align: middle;">Kartu</th>
                  <th class="text-center" style="vertical-align: middle;">Surat.Kntrl</th>
                  <th class="text-center" style="vertical-align: middle;">SEP</th>
                  <th class="text-center" style="vertical-align: middle;">Rncn.Kntrl</th>
                  <th class="text-center" style="vertical-align: middle;">SEP</th>
                  <th class="text-center" style="vertical-align: middle;">Trbt.Kntrl</th>
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
        url: '/bridgingsep/sep-rencana-kontrol-no-kartu',
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
        if (data[0].metaData.code == 201) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          $('tbody').append('<tr> <td colspan="8">'+data[0].metaData.message+'</td> </tr>')
        }
        if (data[0].metaData.code == 200) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty()
          
          $('.poli').removeClass('hidden')
          $('.kelasRawat').addClass('hidden')
          $.each(data[1].list, function(index, val) {
            $('tbody').append('<tr> <td>'+(index + 1)+'</td><td>'+val.namaJnsKontrol+'</td> <td>'+val.nama+'</td> <td>'+val.namaDokter+'</td>  <td class="text-center">'+val.namaPoliAsal+'</td> <td>'+val.namaPoliTujuan+'</td> <td>'+val.noKartu+'</td> <td><a target=__blank href="/bridgingsep/sep-rk-spri?no='+val.noSuratKontrol+'">'+val.noSuratKontrol+'</a></td> <td>'+val.noSepAsalKontrol+'</td> <td>'+val.tglRencanaKontrol+'</td> <td>'+val.tglSEP+'</td><td>'+val.tglTerbitKontrol+'</td></tr>')
          });
        }
      });
    }


  </script>
@endsection
