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
  <h1>Primary Survey (Breathing) - {{baca_unit($unit)}}</h1>
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
        <form method="POST" action="{{url('emr-soap/anamnesis/primary/breathing/'.$unit.'/'.$reg->id)}}" class="form-horizontal">

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
                    <td rowspan="6">Asesmen Keperawatan</td>
                    <td>Pola Napas</td>
                    <td colspan="2">
                      <input type="text" name="breathing[frekuensi]" class="form-control" placeholder="Frekuensi/menit" required>
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Bunyi Napas</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[Vesikuler]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[Vesikuler]" value="vesikuler">
                      Vesikuler
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[wheezing]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[wheezing]" value="wheezing">
                      wheezing
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[ronchi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[ronchi]" value="ronchi">
                      Ronchi
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Tanda Distress Pernapasan</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[tanda_distressototbantu]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[tanda_distressototbantu]" value="Ya">
                      Penggunaan otot bantu
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[tanda_distressretraksi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[tanda_distressretraksi]" value="Ya">
                      Retraksi dada/inter costa
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[tanda_distresscuping]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[tanda_distresscuping]" value="Ya">
                      Cuping hidung
                    </td>
                  </tr>

                  <tr>
                    <td rowspan="2">Jenis Pernapasan</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[jenis_napasdada]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[jenis_napasdada]" value="Pernapasan dada">
                      Pernapasan dada
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[jenis_napasperut]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[jenis_napasperut]" value="pernapasan perut">
                      Pernapasan perut
                    </td>
                  </tr>
                </table>

                <h5><b>Diagnosa Keperawatan</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan</td>
                    <td rowspan="2">Pola Napas Tidak Efektif</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[Aktual]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[Aktual]" value="Aktual">
                      Aktual
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[risiko]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[risiko]" value="Risiko">
                      Risiko
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[potensial]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[potensial]" value="Potensial">
                      Potensial
                    </td>
                    <td>
                      <input type="text" name="riwayat_pengobatan[tidak_efektiflainnya]" value="" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>  
                </table>

                <h5><b>Intervensi</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Intervensi</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[intervensiobservasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[intervensiobservasi]" value="Ya">
                      Lakukan observasi frekuensi irama, kedalaman pernapasan
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[intervensitanda]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[intervensitanda]" value="Ya">
                      Observasi tanda-tanda distress pernapasan
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[intervensiposisi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[intervensiposisi]" value="Ya">
                      Berikan posisi tidur semifowler
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[intervensifisioterapi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[intervensifisioterapi]" value="Ya">
                      Lakukan fisioterapi dada
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[intervensibvn]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[intervensibvn]" value="Ya">
                      berikan ventilasi dengan BVN
                    </td>
                    <tr>
                      <td rowspan="3">
                        <input type="hidden" name="riwayat_pengobatan[intervensikolaborasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[intervensikolaborasi]" value="Ya">
                        Kolaborasi :
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[intervensinasal]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[intervensinasal]" value="Ya">
                        Pemberian O2 (Nasal/RM)
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[intervensinrm]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[intervensinrm]" value="Ya">
                        NRM (lt/menit)
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[intervensiagd]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[intervensiagd]" value="Ya">
                        Pemeriksaan AGD
                      </td>
                      <td>
                        <input type="hidden" name="riwayat_pengobatan[intervensiinhalasi]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[intervensiinhalasi]" value="Ya">
                        Terapi inhalasi (nebulizer)
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                      <input type="text" name="riwayat_pengobatan[intervensilainnya]" class="form-control" placeholder="lainnya" required>
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
                    <td> 
                      <b>Pola Napas :</b> {{json_decode($item->riwayat_pengobatan,true)['frekuensi']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Bunyi napas</td>
                    <td> 
                      <b>Vesikuler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['Vesikuler']}}<br/>
                      <b>Wheezing :</b> {{json_decode(@$item->riwayat_pengobatan,true)['wheezing']}}<br/>
                      <b>Ronchi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['ronchi']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Tanda distress pernapasan</td>
                    <td> 
                      <b>Penggunaan otot bantu :</b> {{json_decode(@$item->riwayat_pengobatan,true)['tanda_distressototbantu']}}<br/>
                      <b>Retraksi dada/inter costa :</b> {{json_decode(@$item->riwayat_pengobatan,true)['tanda_distressretraksi']}}<br/>
                      <b>Cuping hidung :</b> {{json_decode(@$item->riwayat_pengobatan,true)['tanda_distresscuping']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Jenis pernapasan</td>
                    <td> 
                      <b>Pernapasan dada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['jenis_napasdada']}}<br/>
                      <b>Pernapasan perut :</b> {{json_decode(@$item->riwayat_pengobatan,true)['jenis_napasperut']}}<br/>
                    </td>
                 </tr>
                 
                 <tr>
                    <td><b>Diagnosa Keperawatan</b></td>
                 </tr>
                 <tr>
                    <td>Pola nafas tidak efektif</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['Aktual']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['risiko']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['potensial']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['tidak_efektiflainnya']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Lakukan observasi frekuensi irama, kedalaman pernapasan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensiobservasi']}}<br/>
                      <b>Observasi tanda-tanda distress pernapasan :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensitanda']}}<br/>
                      <b>Berikan posisi tidur semifowler/fowler :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensiposisi']}}<br/>
                      <b>Lakukan Fisioterapi dada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensifisioterapi']}}<br/>
                      <b>Berikan ventilasi dengan BVN :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensibvn']}}<br/>
                      <b>Kolaborasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensikolaborasi']}}<br/>
                      <b>Pemberian O2 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensinasal']}}<br/>
                      <b>NRM :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensinrm']}}<br/>
                      <b>Pemeriksaan AGD :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensiagd']}}<br/>
                      <b>Terapi inhalasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['intervensiinhalasi']}}<br/>
                      <b>Lain-lain :</b> {{json_decode($item->riwayat_pengobatan,true)['intervensilainnya']}}<br/>
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
