@extends('master')
@section('header')
  <h1>Update Rujukan<small></small></h1>
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
              <label for="poli" class="col-sm-3 control-label">Nomor Rujukan</label>
              <div class="col-sm-9">
                  <input type="text" name="nomor" value="" class="form-control" style="width: 100%">
                  {{-- <a href="{{url('/bridgingsep/sep-rencana-kontrol')}}">Lihat List Nomor</a> --}}
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
            {!! Form::open(['method' => 'POST', 'url' => 'bridgingsep/edit-spri', 'class' => 'form-horizontal','id'=>'formSPRI']) !!}
            <input type="hidden" name="no_rujukan" class="noRujukan">
            <input type="hidden" name="poli_id" class="poli">
            <input type="hidden" name="kode_dokter" class="kodeDokter">
            <input type="hidden" name="tglRencanaKontrol" class="tglRencana">

            <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-edit"></i> EDIT SPRI</button>
            <button type="button" onclick="deleteSurat()" class="btn btn-danger pull-right"><i class="fa fa-trash"></i> HAPUS</button>

            {!! Form::close() !!}
            <table class="table table-hover table-striped table-bordered">
              <tbody>
                <tr>
                  <th class="" style="vertical-align: middle;width:200px;">No. Rujukan</th>
                  <td><input readonly type="text" name="no_rujukan" class="form-control" style="width: 30%"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Tgl. Rujukan</th>
                  <td><input type="text" name="tgl_rujukan" class="form-control datepicker"  style="width: 30%"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Kode Dokter</th>
                  <td class="kodeDokter"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Nama Dokter</th>
                  <td class="namaDokter"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Poli Tujuan</th>
                  <td class="poli"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Tgl. Rencana Kontrol</th>
                  <td class="tglRencana"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Tgl. Terbit</th>
                  <td class="tglTerbit"></td>
                </tr>
                </tr>

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
    function deleteSurat() { 
      $.ajax({
        url: '/bridgingsep/update-rujukan',
        type: 'POST',
        dataType: 'json',
        data: $('#formSPRI').serialize(), 
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
        if (data[0].metaData.code !== '200') {
          // $('tbody').empty()
          return alert(data[0].metaData.message)
        }
        if (data[0].metaData.code == '200') {
           console.log(data)
           alert('Sukses Hapus rencana kontrol')
           window.location.href = "{{ url('/bridgingsep/sep-rencana-kontrol')}}";
        }
      });
    }
    function tampilkanHistoriSEP() {
      $('.respon').html('');
      $.ajax({
        url: '/bridgingsep/update-rujukan',
        type: 'POST',
        dataType: 'json',
        data: $('#formKunjungan').serialize(),
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
           $('.overlay').addClass('hidden')
        }
      })
      .done(function(data) {
        console.log(data)
        // var decompressData = LZString.decompressFromBase64(res); 
        // data = JSON.parse(res) 
        // console.log(data);
        if (data.meta.code == 201) {
          // $('tbody').empty()
          return alert(data.meta.status)
        }
        if (data.meta.code == 200) {
          // $('tbody').empty()
          $('.overlay').addClass('hidden')
          $('.dataKunjungan').removeClass('hidden')
          $('.noRujukan').text(data.noRujukan)
          $('input[name="no_rujukan"]').val(data.noRujukan) 
          $('input[name="tgl_rujukan"]').val(data.tglRujukan) 
          
          $('.kodeDokter').text(data[1].kodeDokter)
          $('input[name="kode_dokter"]').val(data[1].kodeDokter)
          $('.namaDokter').text(data[1].namaDokter)
          
          $('.poli').text(data[1].poliTujuan)
          $('input[name="poli_id"]').val(data[1].poliTujuan)

          $('.tglRencana').text(data[1].tglRencanaKontrol)
          $('input[name="tglRencanaKontrol"]').val(data[1].tglRencanaKontrol)
          $('.tglTerbit').text(data[1].tglTerbit)

          if(data[1].sep.noSep !== null){
            $('.dataSep').removeClass('hidden')
            $('.noSep').text(data[1].sep.noSep)
            $('.jnsPelayanan').text(data[1].sep.jnsPelayanan)
            $('.hakKelas').text(data[1].sep.peserta.hakKelas)
            $('.kelamin').text(data[1].sep.peserta.kelamin)
            $('.name').text(data[1].sep.peserta.nama)
            $('.no_kartu').text(data[1].sep.peserta.noKartu)
            $('.poliSep').text(data[1].sep.poli)
            $('.tglSep').text(data[1].sep.tglSep)
          }
          // if ($('select[name="jenisPelayanan"]').val() == 1) {
          //   $('.poli').addClass('hidden')
          //   $('.kelasRawat').removeClass('hidden')
          //   $.each(data[1].list, function(index, val) {
          //     $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodePoli+'</td> <td>'+val.namaPoli+'</td>  <td class="text-center">'+val.kapasitas+'</td> <td>'+val.jmlRencanaKontroldanRujukan+'</td> <td>'+val.persentase+'</td></tr>')
          //    });
          // } else {
          //   $('.poli').removeClass('hidden')
          //   $('.kelasRawat').addClass('hidden')
          //   $.each(data[1].list, function(index, val) {
          //     $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodePoli+'</td> <td>'+val.namaPoli+'</td>  <td class="text-center">'+val.kapasitas+'</td> <td>'+val.jmlRencanaKontroldanRujukan+'</td> <td>'+val.persentase+'</td></tr>')
          //   });
          // }
        }
      });
    }


  </script>
@endsection
