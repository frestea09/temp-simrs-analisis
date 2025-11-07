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

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
input[type="time"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
</style>
@section('header')
<h1>Fisik</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/nyeri-inap/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          
          <div class="col-md-12" style="padding-top: 40px">

            <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                    <th class="text-center" style="vertical-align: middle;">User</th>
                  </tr>
                </thead>
              <tbody>
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                    </tr>
                @endif
                @foreach ($riwayats as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                        </td>
                        {{-- @if ( $riwayat->id == request()->asessment_id )
                            <td style="text-align: center; background-color:rgb(172, 247, 162)">
                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                            </td>
                        @else
                            <td style="text-align: center;">
                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                            </td>
                        @endif --}}
                       
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_user($riwayat->user_id) }}
                            {{-- <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}
                            {{-- <a href="{{ url('tarif/') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                        </td>
                    </tr>
                @endforeach
               
              </tbody>
            </table>
           
          </div>

          <h4 class="text-center"><b>ASESMEN NYERI</b></h4>
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style=""> 
              <tr>
                <td style="font-weight: bold; width: 30%">P (Provokatif / Penyebab Nyeri)</td>
                <td>
                  <input type="text" class="form-control" name="fisik[provokatif][penilaian]" value="{{ @$asessment['provokatif']['penilaian'] }}">
                </td>
              </tr>
              <tr>
                <td style="">Hal yang memperburuk nyeri</td>
                <td>
                  <input type="text" class="form-control" name="fisik[provokatif][halMemperburuk]" value="{{ @$asessment['provokatif']['halMemperburuk'] }}">
                </td>
              </tr>
              <tr>
                <td style="">Hal yang memperingan nyeri</td>
                <td>
                  <input type="text" class="form-control" name="fisik[provokatif][halMemperingan]" value="{{ @$asessment['provokatif']['halMemperingan'] }}">
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold; width: 30%">Q (Quality / Kualitas)</td>
                <td>
                  <input class="form-check-input" type="checkbox" name="fisik[quality][1]" id="quality_1" value="true" {{ @$asessment['quality']['1'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="quality_1" style="margin-right: 10px;">Nyeri Tumpul</label>

                  <input class="form-check-input" type="checkbox" name="fisik[quality][2]" id="quality_2" value="true" {{ @$asessment['quality']['2'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="quality_2" style="margin-right: 10px;">Nyeri Tajam</label>

                  <input class="form-check-input" type="checkbox" name="fisik[quality][3]" id="quality_3" value="true" {{ @$asessment['quality']['3'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="quality_3" style="margin-right: 10px;">Panas / Terbakar</label>
                  <br>
                  <input class="form-check-input" type="checkbox" name="fisik[quality][4]" id="quality_4" value="true" {{ @$asessment['quality']['4'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="quality_4" style="margin-right: 10px;">Lain</label>

                  <input type="text" name="fisik[quality][lainnya]" class="form-control" value="{{ @$asessment['quality']['lainnya'] }}" style="width: 400px; display: inline-block;">

                </td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold; width: 30%">R (Regio)</td>
              </tr>
              <tr>
                <td>Lokasi Nyeri</td>
                <td>
                  <input type="text" class="form-control" name="fisik[regio][lokasiNyeri]" value="{{ @$asessment['regio']['lokasiNyeri'] }}">
                </td>
              </tr>
              <tr>
                <td>No Lokasi</td>
                <td>
                  <input type="text" class="form-control" name="fisik[regio][noLokasi]" value="{{ @$asessment['regio']['noLokasi'] }}">
                </td>
              </tr>
              <tr>
                <td>Penjalaran</td>
                <td>
                  <input type="text" class="form-control" name="fisik[regio][penjalaran]" value="{{ @$asessment['regio']['penjalaran'] }}">
                </td>
              </tr>
              
              <tr>
                <td colspan="2" style="font-weight: bold; width: 30%">S (Severity / Skala Nyeri)</td>
              </tr>
              <tr>
                <td>Skor</td>
                <td>
                  <input type="text" class="form-control" name="fisik[severity][skor]" value="{{ @$asessment['severity']['skor'] }}">
                </td>
              </tr>
              <tr>
                <td>Medote</td>
                <td>
                  <input class="form-check-input" type="checkbox" name="fisik[severity][metode][VAS]" id="medoteNyeri_1" value="true" {{ @$asessment['severity']['metode']['VAS'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="medoteNyeri_1" style="margin-right: 10px;">VAS</label>

                  <input class="form-check-input" type="checkbox" name="fisik[severity][metode][NRS]" id="medoteNyeri_2" value="true" {{ @$asessment['severity']['metode']['NRS'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="medoteNyeri_2" style="margin-right: 10px;">NRS</label>

                  <input class="form-check-input" type="checkbox" name="fisik[severity][metode][Wong Baker]" id="medoteNyeri_3" value="true" {{ @$asessment['severity']['metode']['Wong Baker'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="medoteNyeri_3" style="margin-right: 10px;">Wong Baker</label>
                </td>
              </tr>
              <tr>
                <td>Tipe</td>
                <td>
                  <input class="form-check-input" type="checkbox" name="fisik[severity][tipe][Ringan]" id="tipeNyeri_1" value="true" {{ @$asessment['severity']['tipe']['Ringan'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="tipeNyeri_1" style="margin-right: 10px;">Ringan</label>

                  <input class="form-check-input" type="checkbox" name="fisik[severity][tipe][Sedang]" id="tipeNyeri_2" value="true" {{ @$asessment['severity']['tipe']['Sedang'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="tipeNyeri_2" style="margin-right: 10px;">Sedang</label>

                  <input class="form-check-input" type="checkbox" name="fisik[severity][tipe][Berat]" id="tipeNyeri_3" value="true" {{ @$asessment['severity']['tipe']['Berat'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="tipeNyeri_3" style="margin-right: 10px;">Berat</label>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold; width: 30%">T (Tempo / Timing)</td>
              </tr>
              <tr>
                <td>Lama</td>
                <td>
                  <input type="text" class="form-control" name="fisik[timing][lama]" value="{{ @$asessment['timing']['lama'] }}">
                </td>
              </tr>
              <tr>
                <td>Frekuensi</td>
                <td>
                  <input class="form-check-input" type="checkbox" name="fisik[timing][frekuensi][Jarang]" id="timingFrekuensi_1" value="true" {{ @$asessment['timing']['frekuensi']['Jarang'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="timingFrekuensi_1" style="margin-right: 10px;">Jarang</label>

                  <input class="form-check-input" type="checkbox" name="fisik[timing][frekuensi][Sering]" id="timingFrekuensi_2" value="true" {{ @$asessment['timing']['frekuensi']['Sering'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="timingFrekuensi_2" style="margin-right: 10px;">Sering</label>

                  <input class="form-check-input" type="checkbox" name="fisik[timing][frekuensi][Hilang Timbul]" id="timingFrekuensi_3" value="true" {{ @$asessment['timing']['frekuensi']['Hilang Timbul'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="timingFrekuensi_3" style="margin-right: 10px;">Hilang Timbul</label>

                  <input class="form-check-input" type="checkbox" name="fisik[timing][frekuensi][Terus Menerus]" id="timingFrekuensi_4" value="true" {{ @$asessment['timing']['frekuensi']['Terus Menerus'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="timingFrekuensi_4" style="margin-right: 10px;">Terus Menerus</label>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="">
              <tr>
                <td colspan="2" style="font-weight: bold">Wong Baker / VAS</td>
              </tr>
              <tr>
                <td colspan="2">
                  <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 100%; height: 100%;">
                </td>
              </tr>
              <tr>
                <td style="text-align: end;">
                  <input class="form-check-input" type="checkbox" name="fisik[wongBaker][0]" id="wongBaker_1" value="true" {{ @$asessment['wongBaker']['0'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="wongBaker_1" style="margin-right: 10px;">0</label>

                  <input class="form-check-input" type="checkbox" name="fisik[wongBaker][2]" id="wongBaker_2" value="true" {{ @$asessment['wongBaker']['2'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="wongBaker_2" style="margin-right: 10px;">2</label>

                  <input class="form-check-input" type="checkbox" name="fisik[wongBaker][4]" id="wongBaker_3" value="true" {{ @$asessment['wongBaker']['4'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="wongBaker_3" style="margin-right: 10px;">4</label>

                </td>
                <td>
                  <input class="form-check-input" type="checkbox" name="fisik[wongBaker][6]" id="wongBaker_4" value="true" {{ @$asessment['wongBaker']['6'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="wongBaker_4" style="margin-right: 10px;">6</label>

                  <input class="form-check-input" type="checkbox" name="fisik[wongBaker][8]" id="wongBaker_5" value="true" {{ @$asessment['wongBaker']['8'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="wongBaker_5" style="margin-right: 10px;">8</label>

                  <input class="form-check-input" type="checkbox" name="fisik[wongBaker][10]" id="wongBaker_6" value="true" {{ @$asessment['wongBaker']['10'] == 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="wongBaker_6" style="margin-right: 10px;">10</label>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  Keterangan :
                  <ul>
                    <li>0 (Tidak Nyeri)</li>
                    <li>2 (Nyeri Ringan)</li>
                    <li>4 (Nyeri Yang Mengganggu)</li>
                    <li>6 (Nyeri Yang Menyusahkan)</li>
                    <li>8 (Nyeri Hebat)</li>
                    <li>10 (Nyeri Sangat Hebat)</li>
                  </ul>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="">
              <tr>
                <td colspan="2" style="font-weight: bold">NRS</td>
              </tr>
              <tr>
                <td colspan="2">
                  <img src="/images/skalaNyeriNRS.png" alt="" style="width: 100%; height: 100%;">
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="text" class="form-control" name="fisik[nrs][skala]" value="{{ @$asessment['nrs']['skala'] }}" placeholder="mis: 4">
                </td>
              </tr>
            </table>
            
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="">
              <tr>
                <td colspan="2" style="font-weight: bold">Tingkat Nyeri</td>
              </tr>
              <tr>
                <td style="width: 50%;">
                  <ul>
                    <li>0. Tidak ada nyeri</li>
                    <li>1. Nyeri seperti gatal, tersenyum atau nyut-nyutan</li>
                    <li>2. Nyeri seperti melilit atau terpukul</li>
                    <li>3. Nyeri seperti perih atau mules</li>
                    <li>4. Nyeri seperti kram atau kaku</li>
                  </ul>
                </td>
                <td>
                  <ul>
                    <li>5. Nyeri seperti tertekan atau bergerak</li>
                    <li>6. Nyeri seperti terbakaar atau ditusuk-tusuk</li>
                    <li>7, 8, 9. Sangat Nyeri tetapi masih dapat dikontrol oleh klien dengan aktifitas yang bisa dilakukan</li>
                    <li>10. Sangat dan tidak dapat dikontrol oleh klien</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="text" class="form-control" name="fisik[tingkatNyeri][total]" value="{{ @$asessment['tingkatNyeri']['total'] }}" placeholder="mis: 4">
                </td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold">Tipe Nyeri</td>
              </tr>
              <tr>
                <td colspan="2">
                  <ol>
                    <li>1-3 Tipe nyeri ringan (sedikit mengganggu aktivitas sehari-hari)</li>
                    <li>4-6 Tipe nyeri sedang (gangguan nyata terhadap aktivitas sehari-hari)</li>
                    <li>7-10 Tipe nyeri berat (tidak dapat melakukan aktivitas sehari-hari)</li>
                  </ol>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="text" class="form-control" name="fisik[tipeNyeri][skor]" value="{{ @$asessment['tipeNyeri']['skor'] }}" placeholder="mis: 2">
                </td>
              </tr>
            </table>
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
        $("#date_dengan_tanggal").attr('', true);  
         
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

    function penyakitKeluarga() {
      var checkBox = document.getElementById("penyakitKeluargaId");
      var text = document.getElementById("penyakitKeluargaText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function alatBantu() {
      var checkBox = document.getElementById("alatBantuId");
      var text = document.getElementById("alatBantuText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function pendengaran() {
      var checkBox = document.getElementById("pendengaranId");
      var text = document.getElementById("pendengaranText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function penglihatan() {
      var checkBox = document.getElementById("penglihatanId");
      var text = document.getElementById("penglihatanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function sputum() {
      var checkBox = document.getElementById("sputumId");
      var text = document.getElementById("sputumText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function edema() {
      var checkBox = document.getElementById("edemaId");
      var text = document.getElementById("edemaText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function babCair() {
      var checkBox = document.getElementById("babCairId");
      var text = document.getElementById("babCairText");
      var label = document.getElementById("babCairLabel");
      if (checkBox.checked == true){
        text.type = "text";
        label.style.display = "block";
      } else {
         text.type= "hidden";
         label.style.display = "none";
      }
    }

    function kateter() {
      var checkBox = document.getElementById("kateterId");
      var text = document.getElementById("kateterText");
      var label = document.getElementById("kateterLabel");
      if (checkBox.checked == true){
        text.type = "text";
        label.style.display = "block";
      } else {
         text.type= "hidden";
         label.style.display = "none";
      }
    }

    function lokasiLuka() {
      var checkBox = document.getElementById("lokasiLukaId");
      var text = document.getElementById("lokasiLukaText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
         label.style.display = "none";
      }
    }

    function totalResikoJatuhDewasa(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalResikoJatuhDewasaId').value = tot;
    }

    function totalResikoJatuhAnak(){
      var arr = document.getElementsByClassName('resikoJatuhAnak');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalResikoJatuhAnakId').value = tot;
    }

    function alasanCemas() {
      var checkBox = document.getElementById("alasanCemasId");
      var text = document.getElementById("alasanCemasText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function pengasuh() {
      var checkBox = document.getElementById("pengasuhId");
      var text = document.getElementById("pengasuhText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function tempramen() {
      var checkBox = document.getElementById("tempramenId");
      var text = document.getElementById("tempramenText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function perilakuUnik() {
      var checkBox = document.getElementById("perilakuUnikId");
      var text = document.getElementById("perilakuUnikText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function pernahJatuh() {
      var checkBox = document.getElementById("pernahJatuhId");
      var text = document.getElementById("pernahJatuhText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function nyeriGerak() {
      var checkBox = document.getElementById("nyeriGerakId");
      var text = document.getElementById("nyeriGerakText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function konsultasiKomunikasi() {
      var checkBox = document.getElementById("konsultasiKomunikasiId");
      var text = document.getElementById("konsultasiKomunikasiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    </script>
  @endsection