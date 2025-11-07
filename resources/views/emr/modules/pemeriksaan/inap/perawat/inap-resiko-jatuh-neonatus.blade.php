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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/resiko-jatuh-neonatus-inap/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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

          {{-- Anamnesis --}}
          <h4 class="text-center"><b>PENGKAJIAN RESIKO JATUH NEONATUS</b></h4>
          <h5 class="text-center"><b>Semua Neonatus dikategorikan beresiko jatuh</b></h5>
          <div class="col-md-12">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"style=""> 
              <tr>
                <td style="width:30%; font-weight:bold; vertical-align: middle; text-align: center;">
                  <span style="font-size: 14pt;">INTERVENS I</span>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][1]" id="intervens1_1" value="true" {{ @$asessment['intervens1']['1'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_1">Pasang gelang warna kuning tanda resiko jatuh pada pasien</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][2]" id="intervens1_2" value="true" {{ @$asessment['intervens1']['2'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_2">Pasang tanda resiko jatuh pada box / incubator</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][3]" id="intervens1_3" value="true" {{ @$asessment['intervens1']['3'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_3">Orientasi ruangan pada orang tua / keluarga</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][4]" id="intervens1_4" value="true" {{ @$asessment['intervens1']['4'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_4">Dekatkan box bayi dengan ibu</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][5]" id="intervens1_5" value="true" {{ @$asessment['intervens1']['5'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_5">Pastikan selalu ada pendamping</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][6]" id="intervens1_6" value="true" {{ @$asessment['intervens1']['6'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_6">Pastikan lantai dan alas kaki tidak licin</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][7]" id="intervens1_7" value="true" {{ @$asessment['intervens1']['7'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_7">Kontrol rutin oleh perawat / bidan</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][8]" id="intervens1_8" value="true" {{ @$asessment['intervens1']['8'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_8">Bila dirawat dalam incubator, pastikan semua jendela terkunci</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[intervens1][9]" id="intervens1_9" value="true" {{ @$asessment['intervens1']['9'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="intervens1_9">Edukasi orang tua / keluarga</label>
                  </div>
                </td>
              </tr>
              
              <tr>
                <td colspan="2" style="font-weight:bold;">
                  <span style="font-size: 14pt;">EDUKASI YANG DIBERIKAN</span>
                  <div style="padding: 0px 20px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="fisik[edukasiDiberikan][1]" id="edukasi_1" value="true" {{ @$asessment['edukasiDiberikan']['1'] == 'true' ? 'checked' : '' }}>
                      <label class="form-check-label" for="edukasi_1">Pasang gelang warna kuning tanda resiko jatuh pada pasien</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="fisik[edukasiDiberikan][2]" id="edukasi_2" value="true" {{ @$asessment['edukasiDiberikan']['2'] == 'true' ? 'checked' : '' }}>
                      <label class="form-check-label" for="edukasi_2">Pasang tanda resiko jatuh pada box / incubator</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="fisik[edukasiDiberikan][3]" id="edukasi_3" value="true" {{ @$asessment['edukasiDiberikan']['3'] == 'true' ? 'checked' : '' }}>
                      <label class="form-check-label" for="edukasi_3">Orientasi ruangan pada orang tua / keluarga</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="fisik[edukasiDiberikan][4]" id="edukasi_4" value="true" {{ @$asessment['edukasiDiberikan']['4'] == 'true' ? 'checked' : '' }}>
                      <label class="form-check-label" for="edukasi_4">Dekatkan box bayi dengan ibu</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="fisik[edukasiDiberikan][5]" id="edukasi_5" value="true" {{ @$asessment['edukasiDiberikan']['5'] == 'true' ? 'checked' : '' }}>
                      <label class="form-check-label" for="edukasi_5">Pastikan selalu ada pendamping</label>
                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td style="width:30%; font-weight:bold; vertical-align: middle; text-align: center;">
                  <span style="font-size: 14pt;">SASARAN EDUKASI</span>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[sasaranEdukasi][1]" id="sasaran_edukasi_1" value="true" {{ @$asessment['sasaranEdukasi']['1'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sasaran_edukasi_1" style="margin-right: 10px;">Ibu</label>

                    <input class="form-check-input" type="checkbox" name="fisik[sasaranEdukasi][2]" id="sasaran_edukasi_2" value="true" {{ @$asessment['sasaranEdukasi']['2'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sasaran_edukasi_2" style="margin-right: 10px;">Keluarga lain</label>

                    <input class="form-check-input" type="checkbox" name="fisik[sasaranEdukasi][3]" id="sasaran_edukasi_3" value="true" {{ @$asessment['sasaranEdukasi']['3'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sasaran_edukasi_3" style="margin-right: 10px;">Bapak</label>

                    <input class="form-check-input" type="checkbox" name="fisik[sasaranEdukasi][4]" id="sasaran_edukasi_4" value="true" {{ @$asessment['sasaranEdukasi']['4'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sasaran_edukasi_4" style="margin-right: 10px;">Wali</label>
                  </div>

                    <input class="form-check-input" type="checkbox" name="fisik[sasaranEdukasi][5]" id="sasaran_edukasi_5" value="true" {{ @$asessment['sasaranEdukasi']['5'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sasaran_edukasi_5" style="margin-right: 10px;">Lainnya</label>

                    <input type="text" name="fisik[sasaranEdukasi][lainnya]" class="form-control" value="{{ @$asessment['sasaranEdukasi']['lainnya'] }}" style="width: 400px; display: inline-block;">
                </td>
              </tr>

              <tr>
                <td style="width:30%; font-weight:bold; vertical-align: middle; text-align: center;">
                  <span style="font-size: 14pt;">EVALUASI</span>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[evaluasi][1]" id="evaluasi_1" value="true" {{ @$asessment['evaluasi']['1'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="evaluasi_1">Memahami dan mampu menjelaskan kembali</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[evaluasi][2]" id="evaluasi_2" value="true" {{ @$asessment['evaluasi']['2'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="evaluasi_2">Mampu mendemonstrasikan</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="fisik[evaluasi][3]" id="evaluasi_3" value="true" {{ @$asessment['evaluasi']['3'] == 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="evaluasi_3">Perlu edukasi ulang</label>
                  </div>
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
   
  @endsection