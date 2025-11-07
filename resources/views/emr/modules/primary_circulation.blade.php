@extends('master')

<style>
  .form-box td, select,input,textarea{
    font-size: 12px !important;
  }
  .history-family input[type=text]{
    height:20px !important;
    padding:0px !important;
  }
  .history-family-2 td{
    padding:1px !important;
  }
</style>
@section('header')
  <h1>Primary Survey (circulation) - {{baca_unit($unit)}}</h1>
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
        <form method="POST" action="{{ url('/emr/save-riwayat') }}" class="form-horizontal">

          <div class="row">
            <div class="col-md-12">
              {{ csrf_field() }}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
              {!! Form::hidden('cara_bayar', $reg->bayar) !!}
              {!! Form::hidden('unit', $unit) !!} 
              <br> 
              @include('emr.modules.addons.tabs')
              
              <div class="col-md-6">  


                <h5><b>Asesmen Keperawatan</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="16">Asesmen Keperawatan</td>
                    <td rowspan="2">Akral</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[akralhangat]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[akralhangat]" value="Hangat">
                      Hangat
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[akraldingin]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[akraldingin]" value="Dingin">
                      Dingin
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[akraloedema]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[akraloedema]" value="Oedema">
                      Oedema
                    </td>
                  </tr>

                  <tr>
                    <td>Pucat</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[pucatya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[pucatya]" value="Ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[pucattidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[pucattidak]" value="Tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Sianosis</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[sianosisya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[sianosisya]" value="Ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[sianosistidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[sianosistidak]" value="Tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Nadi</td>
                    <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[frekuensi]" class="form-control" placeholder="Frekuensi/menit" required>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[naditeraba]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[naditeraba]" value="Teraba">
                      Teraba
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[nadiTteraba]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[nadiTteraba]" value="Tidak teraba">
                        Tidak Teraba
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Irama :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[iramareguler]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[iramareguler]" value="Reguler">
                        Reguler
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[iramaireguler]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[iramaireguler]" value="Ireguler">
                        Ireguler
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[iramakuat]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[iramakuat]" value="Kuat">
                        Kuat
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[iramalemah]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[iramalemah]" value="Lemah">
                        Lemah
                    </td>
                  </tr>

                  <tr>
                    <td>Tekanan Darah</td>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[tekanandarah]" class="form-control" placeholder="mmHg" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Suhu Badan</td>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[suhubadan]" class="form-control" placeholder="^C" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Perdarahan</td>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[perdarahan]" class="form-control" placeholder="cc" required>
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Luka Bakar</td>
                    <td>Grade</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[lukabakargrade]" class="form-control" placeholder="" required>
                    </td>
                  </tr>
                  <tr>
                    <td>Luas</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[lukabakarluas]" class="form-control" placeholder="%" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Mulai Muntah</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[muntahya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[muntahya]" value="Ya">
                        Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[muntahtidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[muntahtidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Pengisian Kapiler(CRT)</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[crt-20]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[crt-20]" value="<20">
                        -20
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[crt+20]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[crt+20]" value=">20">
                        +20
                    </td>
                  </tr>
                  </table>  

                <h5><b>Diagnosa Keperawatan</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan</td>
                    <td rowspan="2">Gangguan keseimbangan cairan dan elektrolit</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[aktual1]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[aktual1]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[risiko1]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[risiko1]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[potensial1]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[potensial1]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[lain1]" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>
                  
                  <tr>
                    <td rowspan="2">Gangguan Perfusi jaringan perifer</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[aktual2]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[aktual2]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[risiko2]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[risiko2]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[potensial2]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[potensial2]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[lain2]" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>

                  <tr>
                    <td rowspan="2">Gangguan termogulasi</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[hipertermia]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[hipertermia]" value="Hipertemia">
                      Hipertermia
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[hipotermia]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[hipotermia]" value="Hipotermia">
                      Hipotermia
                    </td> 
                  </tr>
                </table>

                

                <h5><b>Intervensi</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Intervensi</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[ttv]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[ttv]" value="Ya">
                      Observasi TTV
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[akral]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[akral]" value="Ya">
                      Nilai Akral
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[monitor]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[monitor]" value="Ya">
                      Monitor perubahan turgor, mukosa, dan CRT
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[peroral]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[peroral]" value="Ya">
                      Berikan Cairan Peroral
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[inout]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[inout]" value="Ya">
                      Monitor Intake - Output
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[urine]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[urine]" value="Ya">
                      Pasang Kateter urine
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[tanda]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[tanda]" value="Ya">
                     Observasi tanda-tanda perdarahan
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[ngt]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[ngt]" value="Ya">
                      Pasang NGT
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[kompres]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[kompres]" value="Ya">
                      Berikan Kompres
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[kolaborasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[kolaborasi]" value="Ya">
                      Kolaborasi untuk pemberian cairan/darah/obat
                    </td> 
                  </tr>
                    <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[lain3]" class="form-control" placeholder="lainnya" required>
                    </td>  
                </table>
              </div> 




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
                @foreach (@$riwayat as $item)
                  <tr>
                    <td><b>Asesmen Keperawatan</b></td>
                  </tr>
                  <tr>
                    <td>Akral</td>
                    <td> 
                      <b>Hangat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['akralhangat']}}<br/>
                      <b>Dingin :</b> {{json_decode(@$item->riwayat_pengobatan,true)['akraldingin']}}<br/>
                      <b>Oedema :</b> {{json_decode(@$item->riwayat_pengobatan,true)['akraloedema']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pucat</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['pucatya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['pucattidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Sianosis</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['sianosisya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['sisnosistidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Nadi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['frekuensi']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Teraba :</b> {{json_decode(@$item->riwayat_pengobatan,true)['naditeraba']}}<br/>
                      <b>Tidak teraba :</b> {{json_decode(@$item->riwayat_pengobatan,true)['nadiTteraba']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Irama</td>
                    <td> 
                      <b>Reguler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['iramareguler']}}<br/>
                      <b>Ireguler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['iramaireguler']}}<br/>
                      <b>Kuat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['iramakuat']}}<br/>
                      <b>Lemah :</b> {{json_decode(@$item->riwayat_pengobatan,true)['iramalemah']}}<br/>
                    </td>
                 </tr>
                  <td> 
                      <b>Tekanan darah :</b> {{json_decode(@$item->riwayat_pengobatan,true)['tekanandarah']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Suhu Badan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['suhubadan']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Perdarahan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['perdarahan']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Luka bakar</td>
                    <td> 
                      <b>Grade :</b> {{json_decode(@$item->riwayat_pengobatan,true)['lukabakargrade']}}<br/>
                      <b>Luas :</b> {{json_decode(@$item->riwayat_pengobatan,true)['lukabakarluas']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Mual muntah</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['muntahya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['muntahtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pengisian kapiler</td>
                    <td> 
                      <b>-20 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['crt-20']}}<br/>
                      <b>+20 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['crt+20']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Turgor</td>
                    <td> 
                      <b>Normal :</b> {{json_decode(@$item->riwayat_pengobatan,true)['turgornormal']}}<br/>
                      <b>Sedang :</b> {{json_decode(@$item->riwayat_pengobatan,true)['turgorsedang']}}<br/>
                      <b>Kurang :</b> {{json_decode(@$item->riwayat_pengobatan,true)['turgorkurang']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Kelembaban kulit</td>
                    <td> 
                      <b>Lembab :</b> {{json_decode(@$item->riwayat_pengobatan,true)['lemab']}}<br/>
                      <b>Kering :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kering']}}<br/>
                    </td>
                 </tr>
                 

                 <tr>
                    <td><b>Diagnosa Keperawatan</b></td>
                 </tr>
                 <tr>
                    <td>Gangguan keseimbangan cairan dan elektrolit</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['aktual1']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['risiko1']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['potensial1']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lain1']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gangguan perfungsi jaringan</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['aktual2']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['risiko2']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['potensial2']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lain2']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gangguan termogulasi</td>
                    <td> 
                      <b>Hipertemia :</b> {{json_decode(@$item->riwayat_pengobatan,true)['hipertermia']}}<br/>
                      <b>Hipotermia :</b> {{json_decode(@$item->riwayat_pengobatan,true)['hipotermia']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Observasi TTV :</b> {{json_decode(@$item->riwayat_pengobatan,true)['ttv']}}<br/>
                      <b>Nilai akral :</b> {{json_decode(@$item->riwayat_pengobatan,true)['akral']}}<br/>
                      <b>Monitor perubahan turgor, mukosa, dan CRT :</b> {{json_decode(@$item->riwayat_pengobatan,true)['monitor']}}<br/>
                      <b>Berikan cairan peroral :</b> {{json_decode(@$item->riwayat_pengobatan,true)['peroral']}}<br/>
                      <b>Moniton intake-output :</b> {{json_decode(@$item->riwayat_pengobatan,true)['inout']}}<br/>
                      <b>Pasang kateter urine :</b> {{json_decode(@$item->riwayat_pengobatan,true)['urine']}}<br/>
                      <b>Observasi tanda-tanda perdarahan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['tanda']}}<br/>
                      <b>Pasang NGT :</b> {{json_decode(@$item->riwayat_pengobatan,true)['ngt']}}<br/>
                      <b>Berikan kompres :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kompres']}}<br/>
                      <b>Kolaborasi untuk pemberian cairan/darah/obat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kolaborasi']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lain3']}}<br/>
                    </td>
                 </tr>

                 <tr>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
              </table>
              </div>
              </div> 
          </div>
        </div>

                {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script>
                  
  function bindRadios(selector){
  $(selector).click(function() {
    $(selector).not(this).prop('checked', false);
  });
};

bindRadios("#radio1, #radio2, #radio3, #radio4, #radio5");
// bindRadios("#radio4, #radio5, #radio6");
                  
                </script> --}}

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
         // ADD RESEP
         
        // HISTORY RESEP 
        // BTN SAVE RESEP
         
        // BTN FINAL RESEP 

        // DELETE DETAIL RESEP 

        // MASTER OBAT  
    </script>
@endsection
