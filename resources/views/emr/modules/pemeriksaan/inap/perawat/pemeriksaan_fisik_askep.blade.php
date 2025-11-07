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
<h1>Pemeriksaan Fisik Askep</h1>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/pemeriksaan-fisik-askep/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('poli', $poli) !!}
          {!! Form::hidden('dpjp', $dpjp) !!}
          <br>
          
          <h5 class="text-center"><b>Pemeriksaan Fisik</b></h5>
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
             <tr>
                <td style="width:20%;">Kepala</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[kepala]" style="width: 100%;" rows="5">{{@$asessment['kepala']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Wajah</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[wajah]" style="width: 100%;" rows="5">{{@$asessment['wajah']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Rambut</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[rambut]" style="width: 100%;" rows="5">{{@$asessment['rambut']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Mata</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[mata]" style="width: 100%;" rows="5">{{@$asessment['mata']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Hidung</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[hidung]" style="width: 100%;" rows="5">{{@$asessment['hidung']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Telinga</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[telinga]" style="width: 100%;" rows="5">{{@$asessment['telinga']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Mulut</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[mulut]" style="width: 100%;" rows="5">{{@$asessment['mulut']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Leher</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[leher]" style="width: 100%;" rows="5">{{@$asessment['leher']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Dada</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[dada]" style="width: 100%;" rows="5">{{@$asessment['dada']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Perut</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[perut]" style="width: 100%;" rows="5">{{@$asessment['perut']}}</textarea>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="width:20%;">Genetalia</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[genetalia]" style="width: 100%;" rows="5">{{@$asessment['genetalia']}}</textarea>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Lubang Anus</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[lubang_anus]" style="width: 100%;" rows="5">{{@$asessment['lubang_anus']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Ekstremitas Atas</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[ekstremitas_atas]" style="width: 100%;" rows="5">{{@$asessment['ekstremitas_atas']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Ekstremitas Bawah</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[ekstremitas_bawah]" style="width: 100%;" rows="5">{{@$asessment['ekstremitas_bawah']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Punggung</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[punggung]" style="width: 100%;" rows="5">{{@$asessment['punggung']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Kulit</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[kulit]" style="width: 100%;" rows="5">{{@$asessment['kulit']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Refleks</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[refleks]" style="width: 100%;" rows="5">{{@$asessment['refleks']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Menangis</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[menangis]" style="width: 100%;" rows="5">{{@$asessment['menangis']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Eliminas</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[eliminas]" style="width: 100%;" rows="5">{{@$asessment['eliminas']}}</textarea>
                </td>
              </tr>
             <tr>
                <td style="width:20%;">Minum</td>
                <td style="padding: 5px;">
                  <textarea name="fisik[minum]" style="width: 100%;" rows="5">{{@$asessment['minum']}}</textarea>
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
    <br/>
    <br/>
    
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  
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
  @endsection