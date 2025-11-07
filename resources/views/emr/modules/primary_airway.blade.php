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
  <h1>Asesmen - {{baca_unit($unit)}}</h1>
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
        <form method="POST" action="{{url('emr-soap/anamnesis/primary/airway/'.$unit.'/'.$reg->id)}}" class="form-horizontal">

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


                <h5><b>Asesmen Keperawatan  - Airway</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="11">Asesmen Keperawatan  - Airway</td>
                    <td>Jalan Napas</td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwayjalan_napasbebas]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayjalan_napasbebas]" value="bebas">
                      Bebas
                    </td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwayjalan_napastidakbebas]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayjalan_napastidakbebas]" value="tidakbebas">
                      Tidak Bebas
                    </td>
                  </tr>

                  <tr>
                    <td>Pangkal Lidah Jatuh</td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwaypangkal_lidahya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaypangkal_lidahya]" value="ya">
                      Ya
                    </td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwaypangkal_lidahtidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaypangkal_lidahtidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Sputum</td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwaysputumya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaysputumya]" value="ya">
                      Ya
                    </td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwaysputumtidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaysputumtidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Darah</td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwaydarahya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaydarahya]" value="ya">
                      Ya
                    </td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwaydarahtidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaydarahtidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Benda Asing</td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwayasingya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayasingya]" value="ya">
                      Ya
                    </td>
                    <td>
                    <input type="hidden" name="riwayat_pengobatan[airwayasingtidak]" value="tidak">
                      <input type="checkbox" name="riwayat_pengobatan[airwayasingtidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Spasme</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwayspasmeya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayspasmeya]" value="ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwayspasmetidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayspasmetidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td colspan="3">Suara Napas</td>
                  </tr>

                  <tr>
                    <td>Gargling</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaygarglingya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaygarglingya]" value="ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaygarglingtidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaygarglingtidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Snorling</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaysnorlingya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaysnorlingya]" value="ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaysnorlingtidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaysnorlingtidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Stridor</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaystridorya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaystridorya]" value="ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaystridortidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaystridortidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Tidak Ada Suara Napas</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaytidak_adaya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaytidak_adaya]" value="ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaytidak_adatidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaytidak_adatidak]" value="tidak">
                      Tidak
                    </td>
                  </tr>
                </table>

                <h5><b>Diagnosa Keperawatan - Airway</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan - Airway<airway/td>
                    <td rowspan="2">Bersihkan Jalan Napas Tidak Efektif</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwayAktual]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayAktual]" value="aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwayrisiko]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwayrisiko]" value="risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[airwaypotensial]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[airwaypotensial]" value="potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[airwaytidak_efektiflainnya]" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>  
                </table>

                <h5><b>Intervensi - Airway</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="5">Intervensi - Airway<airway/td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[airwaybersihkan_jalan]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwaybersihkan_jalan]" value="jalan napas">
                        Bersihkan jalan napas
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwaypengisapan]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwaypengisapan]" value="pengisapan">
                        Lakukan pengisapan/suction
                      </td>
                  </tr>  
                  <tr>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwayheadtilt]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwayheadtilt]" value="tilt_chin_lift">
                        Lakukan head tilt- chin lift
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwayjawtrust]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwayjawtrust]" value="jaw_trust">
                        Lakukan jaw trust
                      </td>
                  </tr>
                  <tr>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwayoronaso]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwayoronaso]" value="oro/naso">
                        Pasang oro/naso faringeal riwayat_pengobatan
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwayposisi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwayposisi]" value="posisi">
                        Berikan posisi yang nyaman
                      </td>
                  </tr>
                  <tr>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwayteknik]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwayteknik]" value="teknik_batuk_efektif">
                        Ajarkan teknik batuk efektif
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[airwayett]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[airwayett]" value="ETT">
                        Pasang ETT
                      </td>
                  </tr>
                  <tr>
                      <td>
                        <input type="text" name="riwayat_pengobatan[airwaylainnya]" placeholder="Lainnya" class="form-control" required>
                      </td>
                  </tr>
                </table>



                <h5><b>Asesmen Keperawatan - Breathing</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Asesmen Keperawatan - Breathing</td>
                    <td>Pola Napas</td>
                    <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[breathingfrekuensi]" class="form-control" placeholder="Frekuensi/menit" required>
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Bunyi Napas</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingVesikuler]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingVesikuler]" value="vesikuler">
                      Vesikuler
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingwheezing]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingwheezing]" value="wheezing">
                      wheezing
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingronchi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingronchi]" value="ronchi">
                      Ronchi
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Tanda Distress Pernapasan</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingtanda_distressototbantu]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingtanda_distressototbantu]" value="Ya">
                      Penggunaan otot bantu
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingtanda_distressretraksi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingtanda_distressretraksi]" value="Ya">
                      Retraksi dada/inter costa
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingtanda_distresscuping]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingtanda_distresscuping]" value="Ya">
                      Cuping hidung
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Jenis Pernapasan</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingjenis_napasdada]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingjenis_napasdada]" value="Pernapasan dada">
                      Pernapasan dada
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingjenis_napasperut]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingjenis_napasperut]" value="pernapasan perut">
                      Pernapasan perut
                    </td>
                  </tr>
                </table>

                <h5><b>Diagnosa Keperawatan - Breathing</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan - Breathing</td>
                    <td rowspan="2">Pola Napas Tidak Efektif</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingAktual]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingAktual]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingrisiko]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingrisiko]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingpotensial]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingpotensial]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[breathingtidak_efektiflainnya]" value="" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>  
                </table>

                <h5><b>Intervensi - Breathing</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Intervensi - Breathing</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingintervensiobservasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingintervensiobservasi]" value="Ya">
                      Lakukan observasi frekuensi irama, kedalaman pernapasan
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingintervensitanda]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingintervensitanda]" value="Ya">
                      Observasi tanda-tanda distress pernapasan
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingintervensiposisi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingintervensiposisi]" value="Ya">
                      Berikan posisi tidur semifowler
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingintervensifisioterapi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingintervensifisioterapi]" value="Ya">
                      Lakukan fisioterapi dada
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[breathingintervensibvn]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[breathingintervensibvn]" value="Ya">
                      berikan ventilasi dengan BVN
                    </td>
                    <tr>
                      <td rowspan="3">
                        <input type="hidden" name="riwayat_pengobatan[breathingintervensikolaborasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[breathingintervensikolaborasi]" value="Ya">
                        Kolaborasi :
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[breathingintervensinasal]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[breathingintervensinasal]" value="Ya">
                        Pemberian O2 (Nasal/RM)
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[breathingintervensinrm]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[breathingintervensinrm]" value="Ya">
                        NRM (lt/menit)
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[breathingintervensiagd]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[breathingintervensiagd]" value="Ya">
                        Pemeriksaan AGD
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[breathingintervensiinhalasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[breathingintervensiinhalasi]" value="Ya">
                        Terapi inhalasi (nebulizer)
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[breathingintervensilainnya]" class="form-control" placeholder="lainnya" required>
                      </td>
                    </tr>
                </table>




                <h5><b>Asesmen Keperawatan - Circulation</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="16">Asesmen Keperawatan - Circulation</td>
                    <td rowspan="2">Akral</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationakralhangat]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationakralhangat]" value="Hangat">
                      Hangat
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationakraldingin]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationakraldingin]" value="Dingin">
                      Dingin
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationakraloedema]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationakraloedema]" value="Oedema">
                      Oedema
                    </td>
                  </tr>

                  <tr>
                    <td>Pucat</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationpucatya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationpucatya]" value="Ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationpucattidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationpucattidak]" value="Tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Sianosis</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationsianosisya]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationsianosisya]" value="Ya">
                      Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationsianosistidak]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationsianosistidak]" value="Tidak">
                      Tidak
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Nadi</td>
                    <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[circulationfrekuensi]" class="form-control" placeholder="Frekuensi/menit" required>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationnaditeraba]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationnaditeraba]" value="Teraba">
                      Teraba
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationnadiTteraba]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationnadiTteraba]" value="Tidak teraba">
                        Tidak Teraba
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Irama :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationiramareguler]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationiramareguler]" value="Reguler">
                        Reguler
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationiramaireguler]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationiramaireguler]" value="Ireguler">
                        Ireguler
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationiramakuat]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationiramakuat]" value="Kuat">
                        Kuat
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationiramalemah]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationiramalemah]" value="Lemah">
                        Lemah
                    </td>
                  </tr>

                  <tr>
                    <td>Tekanan Darah</td>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[circulationtekanandarah]" class="form-control" placeholder="mmHg" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Suhu Badan</td>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[circulationsuhubadan]" class="form-control" placeholder="^C" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Perdarahan</td>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[circulationperdarahan]" class="form-control" placeholder="cc" required>
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Luka Bakar</td>
                    <td>Grade</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[circulationlukabakargrade]" class="form-control" placeholder="" required>
                    </td>
                  </tr>
                  <tr>
                    <td>Luas</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[circulationlukabakarluas]" class="form-control" placeholder="%" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Mulai Muntah</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationmuntahya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationmuntahya]" value="Ya">
                        Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationmuntahtidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationmuntahtidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>

                  <tr>
                    <td>Pengisian Kapiler(CRT)</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationcrt-20]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationcrt-20]" value="<20">
                        -20
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[circulationcrt+20]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[circulationcrt+20]" value=">20">
                        +20
                    </td>
                  </tr>
                  </table>  

                <h5><b>Diagnosa Keperawatan - Circulation</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan - Circulation</td>
                    <td rowspan="2">Gangguan keseimbangan cairan dan elektrolit</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationaktual1]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationaktual1]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationrisiko1]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationrisiko1]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationpotensial1]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationpotensial1]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[circulationlain1]" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>
                  
                  <tr>
                    <td rowspan="2">Gangguan Perfusi jaringan perifer</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationaktual2]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationaktual2]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationrisiko2]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationrisiko2]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationpotensial2]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationpotensial2]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[circulationlain2]" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>

                  <tr>
                    <td rowspan="2">Gangguan termogulasi</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationhipertermia]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationhipertermia]" value="Hipertemia">
                      Hipertermia
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationhipotermia]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationhipotermia]" value="Hipotermia">
                      Hipotermia
                    </td> 
                  </tr>
                </table>

                <h5><b>Intervensi - Circulation</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Intervensi - Circulation</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationttv]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationttv]" value="Ya">
                      Observasi TTV
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationakral]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationakral]" value="Ya">
                      Nilai Akral
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationmonitor]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationmonitor]" value="Ya">
                      Monitor perubahan turgor, mukosa, dan CRT
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationperoral]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationperoral]" value="Ya">
                      Berikan Cairan Peroral
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationinout]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationinout]" value="Ya">
                      Monitor Intake - Output
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationurine]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationurine]" value="Ya">
                      Pasang Kateter urine
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationtanda]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationtanda]" value="Ya">
                     Observasi tanda-tanda perdarahan
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationngt]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationngt]" value="Ya">
                      Pasang NGT
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationkompres]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationkompres]" value="Ya">
                      Berikan Kompres
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[circulationkolaborasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[circulationkolaborasi]" value="Ya">
                      Kolaborasi untuk pemberian cairan/darah/obat
                    </td> 
                  </tr>
                    <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[circulationlain3]" class="form-control" placeholder="lainnya" required>
                    </td>  
                </table>




                <h5><b>Asesmen Keperawatan - Disability</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="14 ">Asesmen Keperawatan - Disability</td>
                    <td rowspan="2">Kesadaran :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitykesadarancm]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitykesadarancm]" value="CM">
                        CM (15)
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitykesadaransomnolen]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitykesadaransomnolen]" value="Somnolen">
                        Somnolen (12-14)
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilitykesadaransopor]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitykesadaransopor]" value="Sopor">
                        Sopor (9-11)
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitykesadarankoma]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitykesadarankoma]" value="Koma">
                        Koma (3-8)
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="3">Nilai GCS :</td>
                    <td>E :</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[disabilitycgse]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td>M :</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[disabilitycgsm]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td>V :</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[disabilitycgsv]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td>Reflek Cahaya :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilityreflekada]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilityreflekada]" value="Ada">
                        Ada
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilityreflektidakada]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilityreflektidakada]" value="Tidak ada">
                        Tidak Ada
                    </td>
                  </tr>
                  <tr>
                    <td>Diameter Pupil :</td>
                    <td colspan="2">
                        <input type="text" class="form-control" name="riwayat_pengobatan[disabilitytxt]" value="" required>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="4">Ekstremitas :</td>
                    <td rowspan="2">Motorik :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitymotorikya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitymotorikya]" value="Ya">
                        Ya
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitymotoriktidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitymotoriktidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                  <td rowspan="2">Sensorik :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitysensorikya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitysensorikya]" value="Ya">
                        Ya
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitysensoriktidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitysensoriktidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td>Kekuatan Otot :</td>
                    <td colspan="2">
                        <input type="text" class="form-control" name="riwayat_pengobatan[disabilityotot]" value="" required>
                    </td>
                  </tr>
                  <tr>
                    <td>Kejang :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitykejangya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitykejangya]" value="Ya">
                        Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitykejangtidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitykejangtidak]" value="Ya">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td>Trismus :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitytrismusya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitytrismusya]" value="Ya">
                        Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[disabilitytrismustidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[disabilitytrismustidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>

                </table>

                <h5><b>Diagnosa Keperawatan - Disability</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan - Disability</td>
                    <td rowspan="2">Ganguan Perfungsi Jaringan</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilityaktual]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilityaktual]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilityrisiko]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilityrisiko]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilitypotensial]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilitypotensial]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[disabilitylain]" value="" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>  
                </table>

                <h5><b>Intervensi - Disability</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Intervensi - Disability</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilityobservasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilityobservasi]" value="Ya">
                      Observasi perubahan tingkat kesadaran
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilitykaji]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilitykaji]" value="Ya">
                      Kaji pupil : isokor, diameter, dan respon cahaya
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilitytinggi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilitytinggi]" value="Ya">
                      Tinggikan Kepala 15-30derajat jika ada kontra indikasi
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[disabilitykolaborasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[disabilitykolaborasi]" value="Ya">
                      Kolaborasi pemberian terapi
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                    <input type="text" name="riwayat_pengobatan[disabilitylain2]" value="" class="form-control" placeholder="lainnya" required>
                    </td>
                  </tr>
                </table>



                <h5><b>Asesmen Keperawatan - Eksposure</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="14 ">Asesmen Keperawatan - Eksposure</td>
                    <td rowspan="7">Adanya trauma/luka :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposuretraumaya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposuretraumaya]" value="Ya">
                         Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[eksposuretraumatidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposuretraumatidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurelaceratum]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurelaceratum]" value="Laceratum">
                        Laceratum
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurefrektur]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurefrektur]" value="Fraktur">
                        Fraktur
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureeksporiasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureeksporiasi]" value="Ekskoriasi">
                        Ekskoriasi
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposuredislokasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposuredislokasi]" value="Dislokasi">
                        Dislokasi
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurehematoma]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurehematoma]" value="Hematoma">
                        Hematoma
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposuremorsun]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposuremorsun]" value="Morsun">
                        Morsun
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurecontusio]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurecontusio]" value="Contusio">
                        Contusio
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurepunctum]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurepunctum]" value="Punctum">
                        Punctum
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[eksposureamputas]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureamputas]" value="Auto">
                        Auto amputasi
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureapulsi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureapulsi]" value="Apulsi">
                        Apulsi
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[eksposure]" value="" class="form-control" placeholder="lainnya" required>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="7">Adanya Nyeri :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurenyeriya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurenyeriya]" value="Ya">
                         Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurenyeritidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurenyeritidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                        <input type="text" namriwayat_pengobatan[eksposure]] value=""" class="form-control" placeholder="lokasi" required>
                    </td>
                  </tr>
                </table>

                <h5><b>Diagnosa Keperawatan - Eksposure</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2 ">Diagnosa Keperawatan - Eksposure</td>
                    <td rowspan="2">Gangguan rasa nyaman nyeri</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureaktual1]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureaktual1]" value="Aktual">
                         Aktual
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurerisiko1]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurerisiko1]" value="Risiko">
                        Risiko
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurepotensial1]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurepotensial1]" value="Potensial">
                        Potensial
                    </td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[eksposurelainnya1]" value="" class="form-control" placeholder="Lainnya" required>
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Gangguan Mobilitas Fisik</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureaktual2]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureaktual2]" value="Aktual">
                         Aktual
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurerisiko2]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurerisiko2]" value="Risiko">
                        Risiko
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurepotensial2]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurepotensial2]" value="Potensial">
                        Potensial
                    </td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[eksposurelainnya2]" value="" class="form-control" placeholder="Lainnya" required>
                    </td>
                  </tr>
                </table>

                <h5><b>Intervensi - Eksposure</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="14 " style="width: 30%;">Intervensi - Eksposure</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureobservasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureobservasi]" value="Ya">
                         Observasi tingkat nyeri
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureteknik]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureteknik]" value="Ya">
                        Ajarkan teknik relaksasi
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurebatas]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurebatas]" value="Ya">
                        batasi aktifitas fisik
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurebidai]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurebidai]" value="Ya">
                         Pasang bidai/spalk
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurePMS]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurePMS]" value="Ya">
                        Cek PMS
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurebalut]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurebalut]" value="Ya">
                        Balut tekan pendarahan
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureperawatan]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureperawatan]" value="Ya">
                         Perawatan luka
                    </td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[eksposuretxt1]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="2">Kolaborasi :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposurerontgen]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposurerontgen]" value="Rontgen">
                        Rontgen
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksposureobat]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksposureobat]" value="Obat">
                        Obat
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="text" name="riwayat_pengobatan[eksposuretxt2]" value="" class="form-control" required>
                    </td>
                  </tr>
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
                    <td><b>Asesmen Keperawatan  - Airway</b></td>
                  </tr>
                  <tr>
                    <td>Jalan napas</td>
                    <td> 
                      <b>Bebas :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayjalan_napasbebas']}}<br/>
                      <b>Tidak Bebas :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayjalan_napastidakbebas']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pangkal lidah jatuh</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaypangkal_lidahya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaypangkal_lidahtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Sputum</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaysputumya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaysputumtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Darah</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaydarahya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaydarahtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Benda asing</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayasingya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayasingtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Spasme</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayspasmeya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayspasmetidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gargling</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaygarglingya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaygarglingtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Snorling</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaysnorlingya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaysnorlingtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Stridor</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaystridorya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaystridortidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Tidak ada suara</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaytidak_adaya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaytidak_adatidak']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Diagnosa Keperawatan - Airway</b></td>
                 </tr>
                 <tr>
                    <td>Bersihkan jalan nafas tidak efektif</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayAktual']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayrisiko']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaypotensial']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['airwaytidak_efektiflainnya']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi - Airway</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Bersihkan jalan napas :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaybersihkan_jalan']}}<br/>
                      <b>Lakukan penginapan/suction :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayrisiko']}}<br/>
                      <b>Lakukan head tilt-chin lift :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaypotensial']}}<br/>
                      <b>Lakukan jaw trust :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaytidak_efektiflainnya']}}<br/>
                      <b>Pasang oro/narso faringeal riwayat_pengobatan :</b> {{json_decode(@$item->airwayriwayat_pengobatan,true)['oronaso']}}<br/>
                      <b>Berikan posisi yang nyaman :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwayrisiko']}}<br/>
                      <b>Ajarkan teknik batuk efektif :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaypotensial']}}<br/>
                      <b>Pasang ETT :</b> {{json_decode(@$item->riwayat_pengobatan,true)['airwaytidak_efektiflainnya']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['airwaylainnya']}}<br/>
                    </td>
                 </tr>

                 <tr>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
              </table>


              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i></i></td>
                </tr>  
                @endif
                @foreach (@$riwayat as $item)
                  <tr>
                    <td><b>Asesmen Keperawatan - Breathing</b></td>
                  </tr>
                  <tr>
                    <td> 
                      <b>Pola Napas :</b> {{json_decode($item->riwayat_pengobatan,true)['breathingfrekuensi']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Bunyi napas</td>
                    <td> 
                      <b>Vesikuler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingVesikuler']}}<br/>
                      <b>Wheezing :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingwheezing']}}<br/>
                      <b>Ronchi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingronchi']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Tanda distress pernapasan</td>
                    <td> 
                      <b>Penggunaan otot bantu :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingtanda_distressototbantu']}}<br/>
                      <b>Retraksi dada/inter costa :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingtanda_distressretraksi']}}<br/>
                      <b>Cuping hidung :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingtanda_distresscuping']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Jenis pernapasan</td>
                    <td> 
                      <b>Pernapasan dada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingjenis_napasdada']}}<br/>
                      <b>Pernapasan perut :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingjenis_napasperut']}}<br/>
                    </td>
                 </tr>
                 
                 <tr>
                    <td><b>Diagnosa Keperawatan - Breathing</b></td>
                 </tr>
                 <tr>
                    <td>Pola nafas tidak efektif</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingAktual']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingrisiko']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingpotensial']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['breathingtidak_efektiflainnya']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi - Breathing</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Lakukan observasi frekuensi irama, kedalaman pernapasan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensiobservasi']}}<br/>
                      <b>Observasi tanda-tanda distress pernapasan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensitanda']}}<br/>
                      <b>Berikan posisi tidur semifowler/fowler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensiposisi']}}<br/>
                      <b>Lakukan Fisioterapi dada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensifisioterapi']}}<br/>
                      <b>Berikan ventilasi dengan BVN :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensibvn']}}<br/>
                      <b>Kolaborasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensikolaborasi']}}<br/>
                      <b>Pemberian O2 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensinasal']}}<br/>
                      <b>NRM :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensinrm']}}<br/>
                      <b>Pemeriksaan AGD :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensiagd']}}<br/>
                      <b>Terapi inhalasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['breathingintervensiinhalasi']}}<br/>
                      <b>Lain-lain :</b> {{json_decode($item->riwayat_pengobatan,true)['breathingintervensilainnya']}}<br/>
                    </td>
                 </tr>

                 <tr>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
              </table>



              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i></i></td>
                </tr>  
                @endif
                @foreach (@$riwayat as $item)
                  <tr>
                    <td><b>Asesmen Keperawatan - Circulation</b></td>
                  </tr>
                  <tr>
                    <td>Akral</td>
                    <td> 
                      <b>Hangat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationakralhangat']}}<br/>
                      <b>Dingin :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationakraldingin']}}<br/>
                      <b>Oedema :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationakraloedema']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pucat</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationpucatya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationpucattidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Sianosis</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationsianosisya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationsisnosistidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Nadi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationfrekuensi']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Teraba :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationnaditeraba']}}<br/>
                      <b>Tidak teraba :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationnadiTteraba']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Irama</td>
                    <td> 
                      <b>Reguler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationiramareguler']}}<br/>
                      <b>Ireguler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationiramaireguler']}}<br/>
                      <b>Kuat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationiramakuat']}}<br/>
                      <b>Lemah :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationiramalemah']}}<br/>
                    </td>
                 </tr>
                  <td> 
                      <b>Tekanan darah :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationtekanandarah']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Suhu Badan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationsuhubadan']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Perdarahan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationperdarahan']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Luka bakar</td>
                    <td> 
                      <b>Grade :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationlukabakargrade']}}<br/>
                      <b>Luas :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationlukabakarluas']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Mual muntah</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationmuntahya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationmuntahtidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pengisian kapiler</td>
                    <td> 
                      <b>-20 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationcrt-20']}}<br/>
                      <b>+20 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationcrt+20']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Turgor</td>
                    <td> 
                      <b>Normal :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationturgornormal']}}<br/>
                      <b>Sedang :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationturgorsedang']}}<br/>
                      <b>Kurang :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationturgorkurang']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Kelembaban kulit</td>
                    <td> 
                      <b>Lembab :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationlemab']}}<br/>
                      <b>Kering :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationkering']}}<br/>
                    </td>
                 </tr>
                 

                 <tr>
                    <td><b>Diagnosa Keperawatan - Circulation</b></td>
                 </tr>
                 <tr>
                    <td>Gangguan keseimbangan cairan dan elektrolit</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationaktual1']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationrisiko1']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationpotensial1']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['circulationlain1']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gangguan perfungsi jaringan</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationaktual2']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationrisiko2']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationpotensial2']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['circulationlain2']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gangguan termogulasi</td>
                    <td> 
                      <b>Hipertemia :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationhipertermia']}}<br/>
                      <b>Hipotermia :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationhipotermia']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi - Circulation</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Observasi TTV :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationttv']}}<br/>
                      <b>Nilai akral :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationakral']}}<br/>
                      <b>Monitor perubahan turgor, mukosa, dan CRT :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationmonitor']}}<br/>
                      <b>Berikan cairan peroral :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationperoral']}}<br/>
                      <b>Moniton intake-output :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationinout']}}<br/>
                      <b>Pasang kateter urine :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationurine']}}<br/>
                      <b>Observasi tanda-tanda perdarahan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationtanda']}}<br/>
                      <b>Pasang NGT :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationngt']}}<br/>
                      <b>Berikan kompres :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationkompres']}}<br/>
                      <b>Kolaborasi untuk pemberian cairan/darah/obat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['circulationkolaborasi']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['circulationlain3']}}<br/>
                    </td>
                 </tr>

                 <tr>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
              </table>


              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i></i></td>
                </tr>  
                @endif
                @foreach (@$riwayat as $item)
                  <tr>
                    <td><b>Asesmen Keperawatan - Disability</b></td>
                  </tr>
                  <tr>
                    <td>Kesadaran</td>
                    <td> 
                      <b>CM15 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykesadarancm']}}<br/>
                      <b>Sopor :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykesadaransomnolen']}}<br/>
                      <b>Somnolen :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykesadaransopor']}}<br/>
                      <b>Koma :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykesadarankoma']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Nilai CGS</td>
                    <td> 
                      <b>E :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitycgse']}}<br/>
                      <b>M :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitycgsm']}}<br/>
                      <b>V :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitycgsv']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pupil</td>
                    <td> 
                      <b>Isokor :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitypupilisokor']}}<br/>
                      <b>Anisokor :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitypupilanisokor']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Reflek cahaya</td>
                    <td> 
                      <b>Ada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilityreflekada']}}<br/>
                      <b>Tidak ada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilityreflektidakada']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Diameter pupil :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitytxt']}}<br/>
                    </td>
                 </tr>
                 <tr>
                 <tr>
                    <td>Ekstremitas</td>
                    <td>Motorik :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitymotorikya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitymotoriktidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Sensorik :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitysensorikya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitysensoriktidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Kekuatan otot :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilityotot']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>kejang :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykejangya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykejangtidak']}}<br/>
                    </td>
                 </tr>
                    <td>Trismus :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitytrismusya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitytrismustidak']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Diagnosa Keperawatan - Disability</b></td>
                 </tr>
                 <tr>
                    <td>Gangguan perfungsi jaringan</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilityAktual']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilityrisiko']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitypotensial']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['disabilitylain']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi - Disability</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Observasi Perubahan dan tingkat kesadaran :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilityobservasi']}}<br/>
                      <b>Kaji pupil : isokor, diameter, dan respon cahaya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykaji']}}<br/>
                      <b>Tinggikan kepala 15-30^ jika ada kontra indikasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitytinggi']}}<br/>
                      <b>Kolaborasi pemberian terapi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['disabilitykolaborasi']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['disabilitylain2']}}<br/>
                    </td>
                 </tr>

                 <tr>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
              </table>



              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i></i></td>
                </tr>  
                @endif
                @foreach (@$riwayat as $item)
                  <tr>
                    <td><b>Asesmen Keperawatan - Eksposure</b></td>
                  </tr>
                  <tr>
                    <td>Adanya trauma/luka</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposuretraumaya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposuretraumatidak']}}<br/>
                      <b>Laceratum :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurelaceratum']}}<br/>
                      <b>Fraktur :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurefrektur']}}<br/>
                      <b>Ekskoriasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureeksporiasi']}}<br/>
                      <b>Dislokasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposuredislokasi']}}<br/>
                      <b>Hematoma :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurehematoma']}}<br/>
                      <b>Contusio :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposuremorsun']}}<br/>
                      <b>Punctum :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurecontusio']}}<br/>
                      <b>Auto amputasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurepunctum']}}<br/>
                      <b>Apulsi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureamputas']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureapulsi']}}<br/>
                    </td>
                 </tr>
                    <td>Adanya nyeri</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurenyeriya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurenyeritidak']}}<br/>
                    </td>
                 </tr>
                 
                 

                 <tr>
                    <td><b>Diagnosa Keperawatan - Eksposure</b></td>
                 </tr>
                 <tr>
                    <td>Gangguan rasa nyaman nyeri</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureaktual1']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurerisiko1']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurepotensial1']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['eksposurelainnya1']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gangguan mobilitas fisik</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureaktual2']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurerisiko2']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurepotensial2']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['eksposurelainnya2']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi - Eksposure</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Observasi tingkat nyeri :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureobservasi']}}<br/>
                      <b>Ajarkan tekhnik relaksasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureteknik']}}<br/>
                      <b>Batasi aktifitas fisik :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurebatas']}}<br/>
                      <b>Pasang bidai/spalk:</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurebidai']}}<br/>
                      <b>Cek PMS :</b> {{json_decode(@$item->riwayat_pengobatan,true)['pms']}}<br/>
                      <b>Balut tekan perdarahan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurebalut']}}<br/>
                      <b>Perawatan Luka :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureperawatan']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['eksposuretxt1']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>kolaborasi</td>
                    <td> 
                      <b>Rontgen :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposurerontgen']}}<br/>
                      <b>Obat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposureobat']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksposuretxt2']}}<br/>
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
        
        <br><br>

        <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
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
