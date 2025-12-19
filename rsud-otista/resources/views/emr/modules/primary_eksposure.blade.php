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
  <h1>Primary Survey (Eksposure) - {{baca_unit($unit)}}</h1>
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
                    <td rowspan="14 ">Asesmen Keperawatan</td>
                    <td rowspan="7">Adanya trauma/luka :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[traumaya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[traumaya]" value="Ya">
                         Ya
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[traumatidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[traumatidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[laceratum]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[laceratum]" value="Laceratum">
                        Laceratum
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[frektur]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[frektur]" value="Fraktur">
                        Fraktur
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[eksporiasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[eksporiasi]" value="Ekskoriasi">
                        Ekskoriasi
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[dislokasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[dislokasi]" value="Dislokasi">
                        Dislokasi
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[hematoma]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[hematoma]" value="Hematoma">
                        Hematoma
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[morsun]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[morsun]" value="Morsun">
                        Morsun
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[contusio]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[contusio]" value="Contusio">
                        Contusio
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[punctum]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[punctum]" value="Punctum">
                        Punctum
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[amputas]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[amputas]" value="Auto">
                        Auto amputasi
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[apulsi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[apulsi]" value="Apulsi">
                        Apulsi
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                        <input type="text" name="riwayat_pengobatan[]" value="" class="form-control" placeholder="lainnya" required>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="7">Adanya Nyeri :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[nyeriya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[nyeriya]" value="Ya">
                         Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[nyeritidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[nyeritidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                        <input type="text" namriwayat_pengobatan[]] value=""" class="form-control" placeholder="lokasi" required>
                    </td>
                  </tr>
                </table>

                <h5><b>Dianosa Keperawatan</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2 ">Diagnosa Keperawatan</td>
                    <td rowspan="2">Gangguan rasa nyaman nyeri</td>
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
                        <input type="text" name="riwayat_pengobatan[lainnya1]" value="" class="form-control" placeholder="Lainnya" required>
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Gangguan Mobilitas Fisik</td>
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
                        <input type="text" name="riwayat_pengobatan[lainnya2]" value="" class="form-control" placeholder="Lainnya" required>
                    </td>
                  </tr>
                </table>

                <h5><b>Intervensi</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="14 " style="width: 30%;">Intervensi</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[observasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[observasi]" value="Ya">
                         Observasi tingkat nyeri
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[teknik]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[teknik]" value="Ya">
                        Ajarkan teknik relaksasi
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[batas]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[batas]" value="Ya">
                        batasi aktifitas fisik
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[bidai]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[bidai]" value="Ya">
                         Pasang bidai/spalk
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[PMS]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[PMS]" value="Ya">
                        Cek PMS
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[balut]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[balut]" value="Ya">
                        Balut tekan pendarahan
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[perawatan]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[perawatan]" value="Ya">
                         Perawatan luka
                    </td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[txt1]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="2">Kolaborasi :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[rontgen]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[rontgen]" value="Rontgen">
                        Rontgen
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[obat]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[obat]" value="Obat">
                        Obat
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="text" name="riwayat_pengobatan[txt2]" value="" class="form-control" required>
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
                    <td><b>Asesmen Keperawatan</b></td>
                  </tr>
                  <tr>
                    <td>Adanya trauma/luka</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['traumaya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['traumatidak']}}<br/>
                      <b>Laceratum :</b> {{json_decode(@$item->riwayat_pengobatan,true)['laceratum']}}<br/>
                      <b>Fraktur :</b> {{json_decode(@$item->riwayat_pengobatan,true)['frektur']}}<br/>
                      <b>Ekskoriasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['eksporiasi']}}<br/>
                      <b>Dislokasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['dislokasi']}}<br/>
                      <b>Hematoma :</b> {{json_decode(@$item->riwayat_pengobatan,true)['hematoma']}}<br/>
                      <b>Contusio :</b> {{json_decode(@$item->riwayat_pengobatan,true)['morsun']}}<br/>
                      <b>Punctum :</b> {{json_decode(@$item->riwayat_pengobatan,true)['contusio']}}<br/>
                      <b>Auto amputasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['punctum']}}<br/>
                      <b>Apulsi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['amputas']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['apulsi']}}<br/>
                    </td>
                 </tr>
                    <td>Adanya nyeri</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['nyeriya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['nyeritidak']}}<br/>
                    </td>
                 </tr>
                 
                 

                 <tr>
                    <td><b>Diagnosa Keperawatan</b></td>
                 </tr>
                 <tr>
                    <td>Gangguan rasa nyaman nyeri</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['aktual1']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['risiko1']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['potensial1']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lainnya1']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Gangguan mobilitas fisik</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['aktual2']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['risiko2']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['potensial2']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lainnya2']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Observasi tingkat nyeri :</b> {{json_decode(@$item->riwayat_pengobatan,true)['observasi']}}<br/>
                      <b>Ajarkan tekhnik relaksasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['teknik']}}<br/>
                      <b>Batasi aktifitas fisik :</b> {{json_decode(@$item->riwayat_pengobatan,true)['batas']}}<br/>
                      <b>Pasang bidai/spalk:</b> {{json_decode(@$item->riwayat_pengobatan,true)['bidai']}}<br/>
                      <b>Cek PMS :</b> {{json_decode(@$item->riwayat_pengobatan,true)['pms']}}<br/>
                      <b>Balut tekan perdarahan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['balut']}}<br/>
                      <b>Perawatan Luka :</b> {{json_decode(@$item->riwayat_pengobatan,true)['perawatan']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['txt1']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>kolaborasi</td>
                    <td> 
                      <b>Rontgen :</b> {{json_decode(@$item->riwayat_pengobatan,true)['rontgen']}}<br/>
                      <b>Obat :</b> {{json_decode(@$item->riwayat_pengobatan,true)['obat']}}<br/>
                      <b>Lainnya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['txt2']}}<br/>
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
