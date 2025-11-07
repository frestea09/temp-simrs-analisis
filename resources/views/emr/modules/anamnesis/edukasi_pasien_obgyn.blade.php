@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }
</style>
@section('header')
<h1>Anamnesis - Edukasi Pasien & Keluarga Obgyn</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/anamnesis/edukasiobgyn/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Edukasi Pasien & Keluarga</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <tr>
                <td style="width:50%;">Kebutuhan Dan Pengajaran (Orang Tua : Ayah / Ibu / Keluarga / lainnya)</td>
                <td style="padding: 5px;">
                  <textarea name="obgyn['kebutuhan_dan_pengajaran']" id="" cols="30" rows="10" required></textarea>
                </td>
              </tr>
              <tr>
                <td rowspan="3" style="width:50%;">Edukasi Di Berikan Kepada</td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[edukasi_diberikan]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[edukasi_diberikan]" type="checkbox" value="Ada" id="flexCheckDefault">
                      Orang Tua
                    </label>
                  </td>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="obgyn[edukasi_diberikan_keluarga]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[edukasi_diberikan_keluarga]" type="checkbox" value="Keluarga" id="edukasiDiberikan" onclick="diberikan()">
                      Keluarga
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="obgyn[hubungan]" placeholder="Hubungan Dengan Pasien" class="form-control" id="edukasiDiberikanText">
                    </td>
                  </tr>
               
              </tr>




              <tr>
                <td rowspan="3" style="width:50%;">Bicara </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[normal]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[normal]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Normal 
                    </label>
                  </td>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="obgyn[gangguan_bicara]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[gangguan_bicara]" type="checkbox" value="Ya" id="bicaraId" onclick="bicara()">
                      Serangan Awal Gangguan Bicara
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="obgyn[kapan_gangguan]" placeholder="Kapan" class="form-control" id="bicaraText">
                    </td>
                  </tr>
               
              </tr>








              <tr>
                <td rowspan="4" style="width:50%;">Bicara Sehari-hari</td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[indonesia]" type="hidden" value="pasif" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[indonesia]" type="checkbox" value="aktif" id="flexCheckDefault">
                      Indonesia (aktif / pasif)
                    </label>
                  </td>
                  <tr>
                    <td>
                      <label class="form-check-label" for="flexCheckDefault">
                        <input class="form-check-input"  name="obgyn[inggris]" type="hidden" value="pasif" id="flexCheckDefault">
                        <input class="form-check-input"  name="obgyn[inggris]" type="checkbox" value="aktif" id="flexCheckDefault">
                        Inggris (aktif / pasif)
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="obgyn[daerah]" type="hidden" value="pasif" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[daerah]" type="checkbox" value="aktif" id="bicaraSeharihariId" onclick="bicaraSeharihari()">
                      Daerah
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="obgyn[jelaskan]" placeholder="Jelaskan" class="form-control" id="bicaraSeharihariText">
                    </td>
                  </tr>
               
              </tr>




              <tr>
                <td  style="width:50%;">Perlu Penerjemah </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[perlu_penerjemah]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[perlu_penerjemah]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Perlu Penerjemah
                    </label>
                  </td>
               
              </tr>




              <tr>
                <td rowspan="7" style="width:50%;">Hambatan Edukasi </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[bahasa]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[bahasa]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Bahasa
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[pendengaran]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[pendengaran]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Pendengaran
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[hilang_memori]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[hilang_memori]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Hilang Memori
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[motivasi_buruk]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[motivasi_buruk]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Motivasi Buruk
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[masalah_penglihatan]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[masalah_penglihatan]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Masalah Penglihatan
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[cemas]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[cemas]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Cemas
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[hambatan_belajar]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[hambatan_belajar]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Tidak Ditemukan Hambatan Belajar
                    </label>
                  </td>
                 </tr>
               
              </tr>






              <tr>
                <td rowspan="7" style="width:50%;">Cara Edukasi Yang Disukai </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[menulis]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[menulis]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Menulis
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[audio_visual]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[audio_visual]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Audio Visual / Gambar
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[diskusi]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[diskusi]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Diskusi
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[membaca]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[membaca]" type="checkbox" value="Ya" id="flexCheckDefault">
                     Membaca
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[mendengar]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[mendengar]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Mendengar
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[demonstrasi]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[demonstrasi]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Demonstrasi
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <input type="text" class="form-control" name="obgyn[lainnya_disukai]" placeholder="Lainnya">
                  </td>
                 </tr>
               
              </tr>






              <tr>
                <td rowspan="4" style="width:50%;">Kebutuhan Edukasi</td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[proses_penyakit]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[proses_penyakit]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Proses Penyakit
                    </label>
                  </td>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[pengobatan]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[pengobatan]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Pengobatan
                    </label>
                  </td>
                 </tr>
                 <tr>
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[nutrisi]" type="hidden" value="Tidak" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[nutrisi]" type="checkbox" value="Ya" id="flexCheckDefault">
                    Nutrisi
                    </label>
                  </td>
                 </tr>   
                 <tr>
                  <td>
                    <input type="text" class="form-control" name="obgyn[lainnya_kebutuhan]" placeholder="Lainnya">
                  </td>
                 </tr>
               
              </tr>








              <tr>
                <td rowspan="3" style="width:50%;">Alergi </td>
              
                  <td>
                    <label class="form-check-label" for="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[tidak_alergi]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[tidak_alergi]" type="checkbox" value="Ya" id="flexCheckDefault">
                      Tidak
                    </label>
                  </td>
                  <tr>
                    <td>
                      <input class="form-check-input"  name="obgyn[ya_alergi]" type="hidden" value="-" id="flexCheckDefault">
                      <input class="form-check-input"  name="obgyn[ya_alergi]" type="checkbox" value="Ya" id="alergiId" onclick="alergi()">
                     Ya
                     
                    </td>
                   
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="obgyn[jelaskan_alergi]" placeholder="jelaskan" class="form-control" id="alergiText">
                    </td>
                  </tr>
               
              </tr>



              











            </table>
          </div>
          {{-- Alergi --}}
          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Catatan Medis</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr>  
                @endif
                @foreach ($riwayat as $item)
                <tr>
                  <td>Edukasi Di berikan Kepada</td>
                  <td> 
                    <b>Orang Tua :</b> {{json_decode(@$item->edukasi_pasien,true)['edukasi_diberikan']}}<br/>
                    <b>Keluarga :</b> {{json_decode(@$item->edukasi_pasien,true)['edukasi_diberikan_keluarga']}}<br/>
                    <b>Hubungan Keluarga  :</b> {{json_decode(@$item->edukasi_pasien,true)['hubungan']}}<br/>
                  </td>
                 </tr>
                 <tr>
                  <td>Bicara</td>
                  <td> 
                    <b>Normal :</b> {{json_decode(@$item->edukasi_pasien,true)['edukasi_diberikan']}}<br/>
                    <b>Serangan Awal Gangguan Bicara :</b> {{json_decode(@$item->edukasi_pasien,true)['gangguan_bicara']}}<br/>
                    <b>Kapan Gangguan Bicara  :</b> {{json_decode(@$item->edukasi_pasien,true)['kapan_gangguan']}}<br/>
                  </td>
                 </tr>
                 <tr>
                  <td>Bicara Sehari hari</td>
                  <td> 
                    <b>Indonesia :</b> {{json_decode(@$item->edukasi_pasien,true)['indonesia']}}<br/>
                    <b>Inggris :</b> {{json_decode(@$item->edukasi_pasien,true)['inggris']}}<br/>
                    <b>Daerah  :</b> {{json_decode(@$item->edukasi_pasien,true)['daerah']}}<br/>
                    <b>Penjelasan Bahasa Daerah  :</b> {{json_decode(@$item->edukasi_pasien,true)['jelaskan']}}<br/>
                  </td>
                 </tr> 
                 <tr>
                  <td>Perlu Penerjemah</td>
                  <td> 
                    <b>Perlu Penerjemah :</b> {{json_decode(@$item->edukasi_pasien,true)['perlu_penerjemah']}}<br/>
                  </td>
                 </tr>
                 <tr>
                  <td>Hambatan Edukasi</td>
                  <td> 
                    <b>Bahasa :</b> {{json_decode(@$item->edukasi_pasien,true)['bahasa']}}<br/>
                    <b>Pendengaran :</b> {{json_decode(@$item->edukasi_pasien,true)['pendengaran']}}<br/>
                    <b>Hilang Memori :</b> {{json_decode(@$item->edukasi_pasien,true)['hilang_memori']}}<br/>
                    <b>Motivasi Buruk :</b> {{json_decode(@$item->edukasi_pasien,true)['motivasi_buruk']}}<br/>
                    <b>Masalah Penglihatan :</b> {{json_decode(@$item->edukasi_pasien,true)['masalah_penglihatan']}}<br/>
                    <b>Cemas :</b> {{json_decode(@$item->edukasi_pasien,true)['cemas']}}<br/>
                    <b>Tidak Ditemukan Hambatan Belajar :</b> {{json_decode(@$item->edukasi_pasien,true)['hambatan_belajar']}}<br/>
                  </td>
                 </tr>
                 <tr>
                  <td>Cara Edukasi Yang Di Sukai</td>
                  <td> 
                    <b>Menulis :</b> {{json_decode(@$item->edukasi_pasien,true)['menulis']}}<br/>
                    <b>Audio Visual / Gambar :</b> {{json_decode(@$item->edukasi_pasien,true)['audio_visual']}}<br/>
                    <b>Diskusi :</b> {{json_decode(@$item->edukasi_pasien,true)['diskusi']}}<br/>
                    <b>Membaca :</b> {{json_decode(@$item->edukasi_pasien,true)['membaca']}}<br/>
                    <b>Mendengar :</b> {{json_decode(@$item->edukasi_pasien,true)['mendengar']}}<br/>
                    <b>Demonstrasi :</b> {{json_decode(@$item->edukasi_pasien,true)['demonstrasi']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->edukasi_pasien,true)['lainnya_disukai']}}<br/>
                  </td>
                 </tr>
                 <tr>
                  <td>Kebutuhan Edukasi</td>
                  <td> 
                    <b>Prosses Penyakit:</b> {{json_decode(@$item->edukasi_pasien,true)['proses_penyakit']}}<br/>
                    <b>Pengobatan :</b> {{json_decode(@$item->edukasi_pasien,true)['pengobatan']}}<br/>
                    <b>Nutrisi :</b> {{json_decode(@$item->edukasi_pasien,true)['nutrisi']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->edukasi_pasien,true)['lainnya_kebutuhan']}}<br/>
                    
                  </td>
                 </tr>
                 <tr>
                  <td>Alergi</td>
                  <td> 
                    <b>Tidak Alergi:</b> {{json_decode(@$item->edukasi_pasien,true)['tidak_alergi']}}<br/>
                    <b>Alergi :</b> {{json_decode(@$item->edukasi_pasien,true)['ya_alergi']}}<br/>
                    <b>Penjelasan Alergi :</b> {{json_decode(@$item->edukasi_pasien,true)['jelaskan_alergi']}}<br/>
                   
                    
                  </td>
                 </tr>

                @endforeach
              </table>
              </div>
              </div> 
          </div>
          
          <br /><br />
        </div>
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  <script>
    function diberikan() {
      var checkBox = document.getElementById("edukasiDiberikan");
      var text = document.getElementById("edukasiDiberikanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicara() {
      var checkBox = document.getElementById("bicaraId");
      var text = document.getElementById("bicaraText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicaraSeharihari() {
      var checkBox = document.getElementById("bicaraSeharihariId");
      var text = document.getElementById("bicaraSeharihariText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function alergi() {
      var checkBox = document.getElementById("alergiId");
      var text = document.getElementById("alergiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    </script>
  @endsection