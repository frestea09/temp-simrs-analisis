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
<h1>Pemeriksaan Umum - Tanda Vital</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/tandavital/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          
          <div class="col-md-12">
            <h5><b>Tanda Vital</b></h5>
            <div class="col-md-6">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                style="font-size:12px;">
                <tr>
                  <td style="width:20%;">Keadaan Umum</td>
                  <td style="padding: 5px;">
                    <input type="text" name="pemeriksaan[keadaan_umum]" class="form-control" id="">
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Kesadaran</td>
                  <td style="padding: 5px;"><input type="text" name="pemeriksaan[kesadaran]" style="display:inline-block"
                      class="form-control" id=""/></td>
                </tr>
                <tr>
                  <td style="width:20%;">Tekanan Darah (Sistolik/Distolik) mmHg :</td>
                  <td style="padding: 5px;"><input style="width:30%;display:inline-block" type="number" value="0" name="pemeriksaan[tekanan_darah][]" class="form-control"/> / <input style="width:30%;display:inline-block" type="number" value="0" name="pemeriksaan[tekanan_darah][]" class="form-control"/></td>
                </tr>
                <tr>
                  <td style="width:20%;">Suhu(OC)</td>
                  <td style="padding: 5px;"><input type="text" name="pemeriksaan[suhu]" style="display:inline-block"
                      class="form-control" value="0"></td>
                </tr>
              </table>
            </div>
            
            <div class="col-md-6"> 
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                style="font-size:12px;">
                <tr>
                  <td style="width:20%;">Saturasi O2</td>
                  <td style="padding: 5px;">
                    <input type="number" value="0" name="pemeriksaan[saturasi]" style="display:inline-block" class="form-control" id="">
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Frekuensi Nadi (X/Menit)</td>
                  <td style="padding: 5px;"><input type="number" value="0" name="pemeriksaan[nadi]" style="display:inline-block" class="form-control" id=""></td>
                </tr>
                <tr>
                  <td style="width:20%;">Frekuensi Nafas (X/Menit)</td>
                  <td style="padding: 5px;"><input type="number" value="0" name="pemeriksaan[nafas]" style="display:inline-block" class="form-control" id=""></td>
                </tr>
                <tr>
                  <td style="width:20%;">Waktu Pemeriksaan</td>
                  <td style="padding: 5px;"><input type="date" value="{{date('Y-m-d')}}" name="pemeriksaan[waktu]" class="form-control"/></td>
                </tr>
              </table>
            </div>
          </div>
          
          
          <br /><br />
        </div>
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
      <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
          <thead>
            <tr>
              <th>Keadaan Umum</th>
              <th>Kesadaran</th>
              <th>Sistolik</th>
              <th>Frekuensi Nadi</th>
              <th>Frekuensi Nafas</th>
              <th>Suhu</th>
              <th>Saturasi O2</th>
              <th>Waktu Pemeriksaan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{json_decode($item->tanda_vital,true)['keadaan_umum']}}</td>
                <td>{{json_decode($item->tanda_vital,true)['kesadaran']}}</td>
                <td>{{json_decode($item->tanda_vital,true)['tekanan_darah'][0]}} /{{json_decode($item->tanda_vital,true)['tekanan_darah'][1]}}</td>
                <td>{{json_decode($item->tanda_vital,true)['nadi']}}</td>
                <td>{{json_decode($item->tanda_vital,true)['nafas']}}</td>
                <td>{{json_decode($item->tanda_vital,true)['suhu']}}</td>
                <td>{{json_decode($item->tanda_vital,true)['saturasi']}}</td>
                <td>{{date('d-m-Y',strtotime(json_decode($item->tanda_vital,true)['waktu']))}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
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
  @endsection