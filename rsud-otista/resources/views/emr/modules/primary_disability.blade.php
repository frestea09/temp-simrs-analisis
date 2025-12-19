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
  <h1>Primary Survey (Disability) value="" - {{baca_unit($unit)}}</h1>
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
                    <td rowspan="2">Kesadaran :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[kesadarancm]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[kesadarancm]" value="CM">
                        CM (15)
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[kesadaransomnolen]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[kesadaransomnolen]" value="Somnolen">
                        Somnolen (12-14)
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[kesadaransopor]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[kesadaransopor]" value="Sopor">
                        Sopor (9-11)
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[kesadarankoma]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[kesadarankoma]" value="Koma">
                        Koma (3-8)
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="3">Nilai GCS :</td>
                    <td>E :</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[cgse]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td>M :</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[cgsm]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td>V :</td>
                    <td>
                        <input type="text" name="riwayat_pengobatan[cgsv]" value="" class="form-control" required>
                    </td>
                  </tr>
                  <tr>
                    <td>Reflek Cahaya :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[reflekada]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[reflekada]" value="Ada">
                        Ada
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[reflektidakada]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[reflektidakada]" value="Tidak ada">
                        Tidak Ada
                    </td>
                  </tr>
                  <tr>
                    <td>Diameter Pupil :</td>
                    <td colspan="2">
                        <input type="text" class="form-control" name="riwayat_pengobatan[txt]" value="" required>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="4">Ekstremitas :</td>
                    <td rowspan="2">Motorik :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[motorikya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[motorikya]" value="Ya">
                        Ya
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[motoriktidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[motoriktidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                  <td rowspan="2">Sensorik :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[sensorikya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[sensorikya]" value="Ya">
                        Ya
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[sensoriktidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[sensoriktidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td>Kekuatan Otot :</td>
                    <td colspan="2">
                        <input type="text" class="form-control" name="riwayat_pengobatan[otot]" value="" required>
                    </td>
                  </tr>
                  <tr>
                    <td>Kejang :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[kejangya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[kejangya]" value="Ya">
                        Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[kejangtidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[kejangtidak]" value="Ya">
                        Tidak
                    </td>
                  </tr>
                  <tr>
                    <td>Trismus :</td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[trismusya]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[trismusya]" value="Ya">
                        Ya
                    </td>
                    <td>
                        <input type="hidden" name="riwayat_pengobatan[trismustidak]" value="-">
                        <input type="checkbox" name="riwayat_pengobatan[trismustidak]" value="Tidak">
                        Tidak
                    </td>
                  </tr>

                </table>

                <h5><b>Diagnosa Keperawatan</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="2">Diagnosa Keperawatan</td>
                    <td rowspan="2">Ganguan Perfungsi Jaringan</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[aktual]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[aktual]" value="Aktual">
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
                      <input type="text" name="riwayat_pengobatan[lain]" value="" class="form-control" placeholder="lainnya" required>
                    </td> 
                  </tr>  
                </table>

                <h5><b>Intervensi</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td rowspan="6">Intervensi</td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[observasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[observasi]" value="Ya">
                      Observasi perubahan tingkat kesadaran
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[kaji]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[kaji]" value="Ya">
                      Kaji pupil : isokor, diameter, dan respon cahaya
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[tinggi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[tinggi]" value="Ya">
                      Tinggikan Kepala 15-30derajat jika ada kontra indikasi
                    </td>
                    <td>
                      <input type="hidden" name="riwayat_pengobatan[kolaborasi]" value="-">
                      <input type="checkbox" name="riwayat_pengobatan[kolaborasi]" value="Ya">
                      Kolaborasi pemberian terapi
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                    <input type="text" name="riwayat_pengobatan[lain2]" value="" class="form-control" placeholder="lainnya" required>
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
                    <td>Kesadaran</td>
                    <td> 
                      <b>CM15 :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kesadarancm']}}<br/>
                      <b>Sopor :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kesadaransomnolen']}}<br/>
                      <b>Somnolen :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kesadaransopor']}}<br/>
                      <b>Koma :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kesadarankoma']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Nilai CGS</td>
                    <td> 
                      <b>E :</b> {{json_decode(@$item->riwayat_pengobatan,true)['cgse']}}<br/>
                      <b>M :</b> {{json_decode(@$item->riwayat_pengobatan,true)['cgsm']}}<br/>
                      <b>V :</b> {{json_decode(@$item->riwayat_pengobatan,true)['cgsv']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Pupil</td>
                    <td> 
                      <b>Isokor :</b> {{json_decode(@$item->riwayat_pengobatan,true)['pupilisokor']}}<br/>
                      <b>Anisokor :</b> {{json_decode(@$item->riwayat_pengobatan,true)['pupilanisokor']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Reflek cahaya</td>
                    <td> 
                      <b>Ada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['reflekada']}}<br/>
                      <b>Tidak ada :</b> {{json_decode(@$item->riwayat_pengobatan,true)['reflektidakada']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Diameter pupil :</b> {{json_decode(@$item->riwayat_pengobatan,true)['txt']}}<br/>
                    </td>
                 </tr>
                 <tr>
                 <tr>
                    <td>Ekstremitas</td>
                    <td>Motorik :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['motorikya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['motoriktidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>Sensorik :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['sensorikya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['sensoriktidak']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Kekuatan otot :</b> {{json_decode(@$item->riwayat_pengobatan,true)['otot']}}<br/>
                    </td>
                 </tr>
                 <tr>
                    <td>kejang :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kejangya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kejangtidak']}}<br/>
                    </td>
                 </tr>
                    <td>Trismus :</td>
                    <td> 
                      <b>Ya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['trismusya']}}<br/>
                      <b>Tidak :</b> {{json_decode(@$item->riwayat_pengobatan,true)['trismustidak']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Diagnosa Keperawatan</b></td>
                 </tr>
                 <tr>
                    <td>Gangguan perfungsi jaringan</td>
                    <td> 
                      <b>Aktual :</b> {{json_decode(@$item->riwayat_pengobatan,true)['Aktual']}}<br/>
                      <b>Risiko :</b> {{json_decode(@$item->riwayat_pengobatan,true)['risiko']}}<br/>
                      <b>Potensial :</b> {{json_decode(@$item->riwayat_pengobatan,true)['potensial']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lain']}}<br/>
                    </td>
                 </tr>

                 <tr>
                    <td><b>Intervensi</b></td>
                 </tr>
                 <tr>
                    <td> 
                      <b>Observasi Perubahan dan tingkat kesadaran :</b> {{json_decode(@$item->riwayat_pengobatan,true)['observasi']}}<br/>
                      <b>Kaji pupil : isokor, diameter, dan respon cahaya :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kaji']}}<br/>
                      <b>Tinggikan kepala 15-30^ jika ada kontra indikasi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['tinggi']}}<br/>
                      <b>Kolaborasi pemberian terapi :</b> {{json_decode(@$item->riwayat_pengobatan,true)['kolaborasi']}}<br/>
                      <b>Lainnya :</b> {{json_decode($item->riwayat_pengobatan,true)['lain2']}}<br/>
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
