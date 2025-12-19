@extends('layouts.landingpage')
@section('style')
<style>
  .select2-results__option,
  .select2-search__field,
  .select2-selection__rendered,
  .form-control,
  .col-form-label {
    font-size: 12px;
  }

  .table-pasien tr td {
    padding: 5px !important;
    font-size: 12px;
  }

  th {
    font-weight: 700 !important;
  }

  #dataPasien td,
  #dataPasien th {
    padding: 0.25rem !important;
  }

  select[readonly] {
    background: #eee;
    /*Simular campo inativo - Sugestão @GabrielRodrigues*/
    pointer-events: none;
    touch-action: none;
  }
</style>
@endsection
@section('content')
<div class="container">
  {{-- <h4 class="text-dark text-center">Pendaftaran Online Pasien Baru</h4> --}}
  {{-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Library</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data</li>
    </ol>
  </nav> --}}
  {{--
  <hr /> --}}
  <div class="row">
    <div class="col-lg-12">
      <a href="{{url('/reservasi/cek')}}" class="btn btn-danger btn-sm col-md-2 col-lg-2 float-right"><i
          class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
      <b style="font-weight:700;">CETAK SEP PASIEN </b>

    </div>
  </div>
  <br />
  <div class="row">
    <div class="col-lg-12">
      @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ Session::get('error') }}.</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      {{-- <div class="card border-info">
        <div class="card-header bg-info">
          <span style="color:white">Form Scan No. Rujukan </span>
        </div>
        <div class="card-body">
          <form class="form-horizontal" id="form">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group row">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">No. Rujukan
              </label>
              <div class="col-sm-4">
                <input id="keyword" autocomplete="off" type="text" name="keyword" value="" class="form-control"
                  style="width: 100%" onkeyup="this.value =
                            this.value.toUpperCase()" placeholder="Masukkan nomor rujukan">
              </div>
              <input type="hidden" name="tglperiksa" value="{{date('d-m-Y')}}" class="form-control" style="width: 100%">

              <div class="col-sm-4">
                <button class="btn btn-info col-md-8 col-lg-8 btnCari btn-sm float-left" type="button"
                  onclick="tampil()">
                  <i class="fa fa-search"></i> CARI
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>&nbsp;
                </button>
              </div>
            </div>
          </form>

        </div>
      </div> --}}
    </div>
  </div>

  <div class="row dataKunjungan mt-1">
    <div class="col-lg-12">
      <div class="card border-success">
        <div class="card-header bg-warning text-light">
          Hasil Pencarian
        </div>
        <form id="formCekin" class="rowAntrian">
          {{ csrf_field() }}
          <input type="hidden" name="no_rm" value="{{$regdum->no_rm}}">
          <input type="hidden" name="type_sep" value="sep_baru">
          <input type="hidden" name="kode_poli" value="{{$data[1]['rujukan']['poliRujukan']['kode']}}">
          <input type="hidden" name="nik" value="{{$data[1]['rujukan']['peserta']['nik']}}">
          {{-- <input type="hidden" name="nohp" value="{{$data[1]['rujukan']['peserta']['mr']['noTelepon']}}"> --}}
          <input type="hidden" name="nomorkartu" value="{{$data[1]['rujukan']['peserta']['noKartu']}}">
          <input type="hidden" name="id_reg_dum" value="{{$regdum->id}}">
          <input type="hidden" name="diagnosa_awal" value="{{$data[1]['rujukan']['diagnosa']['kode']}}">
          <input type="hidden" name="no_rujukan" value="{{$data[1]['rujukan']['noKunjungan']}}">
          <input type="hidden" name="tgl_rujukan" value="{{$data[1]['rujukan']['tglKunjungan']}}">
          <input type="hidden" name="ppk_rujukan" value="{{$data[1]['rujukan']['provPerujuk']['kode']}}">
          <input type="hidden" name="nama_ppk_rujukan" value="{{$data[1]['rujukan']['provPerujuk']['nama']}}">
          <input type="hidden" name="poli_bpjs" value="{{$data[1]['rujukan']['poliRujukan']['kode']}}">
          <input type="hidden" name="nik" value="{{$data[1]['rujukan']['peserta']['nik']}}">
          <input type="hidden" name="asalRujukan" value="{{$data[1]['asalFaskes']}}">
          <input type="hidden" name="hak_kelas_inap" value="{{$data[1]['rujukan']['peserta']['hakKelas']['kode']}}">
          <input type="hidden" name="hak_kelas_inap_naik" value="">
          <input type="hidden" name="nama" value="{{$data[1]['rujukan']['peserta']['nama']}}">
          <input type="hidden" name="jeniskelamin" value="{{$data[1]['rujukan']['peserta']['sex']}}">
          <input type="hidden" name="tanggallahir" value="{{$data[1]['rujukan']['peserta']['tglLahir']}}">
          <input type="hidden" value="0" name="katarak">
          <input type="hidden" value="1" name="billing">
          <input type="hidden" value="" name="flagProcedure">
          <input type="hidden" value="" name="kdPenunjang">
          <input type="hidden" value="" name="assesmentPel">
          <input type="hidden" value="" name="noSurat">
          {{-- TUJUAN NORMAL --}}
          <input type="hidden" value="0" name="tujuanKunj">
          {{-- RUJUKAN FKTP --}}
          <input type="hidden" value="1" name="jenisKunjungan">
            <div class="card-body">
              <div class="row ">
                <div class="col-md-12" style="float: none;margin: 0 auto;">
                  <table class="table table-hover table-bordered text-sm"
                    style="font-size: 12px !important;margin: auto !important;">
                    <thead>
                      <tr>
                        <th>No. Rujukan</th>
                        <td>{{$data[1]['rujukan']['noKunjungan']}}</td>
                      </tr>
                      <tr>
                        <th style="width:150px;">Nama (RM)</th>
                        <td> <span class="nama"></span> <b style="font-weight:700">{{$data[1]['rujukan']['peserta']['nama']}}<span class="norm"> ({{$regdum->no_rm}})</span></b>
                          </td>
                      </tr>
                      {{-- <tr>
                        <th style="width:150px;">Kelamin</th>
                        <td> <span class="kelamin"></span> </td>
                      </tr> --}}
                      {{-- <tr>
                        <th style="width:150px;">Tgl. Lahir</th>
                        <td> <span class="tgllahir"></span> </td>
                      </tr> --}}
                      <tr>
                        <th style="width:150px;">No. Kartu</th>
                        <td> <span class="noka">{{$data[1]['rujukan']['peserta']['noKartu']}}</span> </td>
                      </tr>
                      <tr>
                        <th style="width:150px;">Perujuk / Poli Tujuan</th>
                        <td> <span class="perujuk">{{@$data[1]['rujukan']['provPerujuk']['nama']}}</span> <b>/</b> {{$data[1]['rujukan']['poliRujukan']['nama']}}</td>
                      </tr>
                      {{-- <tr>
                        <th style="width:150px;">Poli Tujuan</th>
                        <td> 
                          <span class="poli">{{$data[1]['rujukan']['poliRujukan']['nama']}}</span>
                        </td> 
                      </tr> --}}
                      <tr>
                        <th style="width:150px;">No. Telp</th>
                        <td> 
                          <input type="text" id="noHp" name="nohp" class="form-control" value="{{$data[1]['rujukan']['peserta']['mr']['noTelepon']}}"/></td>
                        </td> 
                      </tr>
                      <tr>
                        <th>Dokter</th>
                        <td>
                          @if ($kode_hfis == 201)
                          
                            <input type="hidden" name="dokter_id" value="{{@$regdum->kode_dokter}}_{{baca_dokter_bpjs($regdum->kode_dokter)}}_{{@$regdum->jampraktek}}_{{@$regdum->kode_poli}}_{{@baca_kode_poli($regdum->kode_poli)}}">
                            {{-- <i><b style="color:red;font-size:14px;font-weight:900">Maaf, tidak ada jadwal dokter poli untuk hari ini </b></i>     --}}
                            @else
                            <select name="dokter_id" id="dokter_id" class="form-control select2">
                              @foreach ($dokter_hfis[1] as $item)
                                  <option {{$regdum->kode_dokter == $item['kodedokter'] ? 'selected' :'' }} value="{{$item['kodedokter']}}_{{$item['namadokter']}}_{{$item['jadwal']}}_{{$item['kodepoli']}}_{{$item['namapoli']}}">{{$item['namadokter']}}</option>
                              @endforeach
                            </select>
                          @endif
                        </td>
                      </tr>
                    </thead>
                    <tbody>
    
                    </tbody> 
                  </table>

                  <table style="width:100%;">
                   
                    <tr>
                      <td colspan="2" class="text-center">
                        <br/>
                        <button style="background-color:green;border:1px solid green;" class="btn btn-success btn-cekin btn-md">CETAK SEP <span class="fa fa-print"></span>&nbsp;<span class="spinner-border spin-cekin spinner-border-sm d-none" role="status" aria-hidden="true"></span>&nbsp;</button>
                        
                      </td>
                    </tr>
                  </table>
                </div> 
                {{-- <div class="col-md-6">
                  
                </div> --}}
    
              </div>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    // submit form reservasi
    $(document).ready(function() {
    // $('#keyword').focus();
      $('#keyword').keyboard()
      $('#noHp').keyboard()
    })
    $('#formCekin').submit(function(event) {
      event.preventDefault();
      if(!$("#noHp").val()){
        Swal.fire({
          icon: 'error',
          title: 'Maaf...',
          text: 'No HP wajib diisi'
        })

        return true;
      }
      //  console.log($('#formCekin').serialize())
      //  return
        $.ajax({
            url: '/reservasi/store-cekin-sep',
            type: 'POST',
            dataType: 'json',
            data: $('#formCekin').serialize(), 
            beforeSend: function () {
              $('.btn-cekin').addClass('disabled')
              $('.spin-cekin').removeClass('d-none')
            },
            complete: function () {
              $('.btn-cekin').removeClass('disabled')
              $('.spin-cekin').addClass('d-none')
            }
        })
        .done(function(res) {
          if(res.metadata.code == 201){
            return Swal.fire({
              icon: 'error',
              title: 'Maaf...',
              text: res.metadata.message
            })
            
          } 
          // console.log(res);
          // return
          if(res.metadata.code == 200){
            // $('input[name="id_reservasi"]').val(res.response.id);
            // cetak(res.response.id)
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Berhasil...',
            //     text: 'Berhasil Cetak SEP, Klik OK lalu tunggu SEP Tampil'
            // }).then(() => {
            /* Read more about isConfirmed, isDenied below */
            return window.location.href = "/reservasi/cetak-baru/"+res.metadata.id+"/"+res.metadata.norm
            // })
            
          }
            
        }); 
    });

  $("#form").submit(function(e){
    e.preventDefault();
    tampil()
  });

  function tampil() {
  $('.cetak').empty()
  $('dataKunjungan').empty()
  $('.dataKunjungan').addClass('d-none')
  $('.respon').html('');
  $.ajax({
    url: '/reservasi/cek-baru',
    type: 'POST',
    dataType: 'json',
    data: $('#form').serialize(), 
    beforeSend: function () {
      $('.btnCari').addClass('disabled')
      $('.spinner-border').removeClass('d-none')
    },
    complete: function () {
       $('.btnCari').removeClass('disabled')
       $('.spinner-border').addClass('d-none')
    }
  })
  .done(function(data) {
    // console.log(data)
    // var decompressData = LZString.decompressFromBase64(res);  
    // data = JSON.parse(data) 
    // console.log(data)
    if (data.result[0].metaData.code == 200) {
      noRujukans = data.result[1].rujukan.noKunjungan
      url = '/reservasi/cekin-pasien-baru/'+noRujukans
      return window.location.href = url
      $('.dataKunjungan').removeClass('d-none')
      $('dataKunjungan').empty()
      // console.log(data)
      // if(data.result.status == 'pending' && data.result.fingerprint.kode == '1'){
      // if(data.result.status == 'pending'){
        cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success float-right btn-sm" href="/reservasi/checkin/'+data.result.id+'/'+data.result.no_rm+'">CHECK IN <span class="fa fa-print"></span></a>';
      // }else if(data.result.status == 'checkin'){
        // cetak = '<a class="btn btn-primary btn-sm" href="/reservasi/cetak/'+data.result.id+'"><span class="fa fa-print"></span>&nbsp;CETAK TIKET</a>';
      // }
      // else{
      //   cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success btn-sm disabled" href=""><span class="fa fa-print"></span>&nbsp;Lanjutkan</a>';
      // }
      // $.each(data.result, function(index, val) {
        
      $('.nama').text(data.result[1].rujukan.peserta.nama)
      $('.noka').text(data.result[1].rujukan.peserta.noKartu)
      $('.kelamin').text(data.result[1].rujukan.peserta.sex)
      $('.tgllahir').text(data.result[1].rujukan.peserta.tglLahir)
      $('.norm').text(data.result[1].rujukan.peserta.mr.noMR)
      $('.notelp').text(data.result[1].rujukan.peserta.mr.noTelepon)
      $('.poli').text(data.result[1].rujukan.poliRujukan.nama)
      $('.keluhan').text(data.result[1].rujukan.keluhan)
      $('.tglkunj').text(data.result[1].rujukan.tglKunjungan)
      $('.tglkunj').text(data.result[1].rujukan.tglKunjungan)
      $('.cetak').append(cetak)
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Maaf...',
        text: data.result[0].metaData.message
      })
    }
  });
}
// })



</script>
@endsection