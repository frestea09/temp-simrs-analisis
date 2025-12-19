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
<h1>Anamnesis - Edukasi Pasien</h1>
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
    <form method="POST" action="{{ url('emr-soap/anamnesis/rencana/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>Rencana</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr> 
                <td>Rencana</td>
                <td style="padding: 5px;">
                  <textarea rows="15" name="rencana[rencana]" style="display:inline-block"
                    class="form-control" id="" required></textarea>
                </td>
              </tr>  
              <tr> 
                <td rowspan="3">Konsul Ke</td>
                <td style="padding: 5px;">
                  <input type="hidden" name="rencana[spesialis_gizi_klinik]" value="-">
                  <input type="checkbox" name="rencana[spesialis_gizi_klinik]" value="Spesialis Gizi Klinik"> &nbsp; <b>Spesialis Gizi Klinik</b>
                  <tr>
                    <td>
                      <input type="hidden" name="rencana[rehabilitasi_medik]" value="-">
                      <input type="checkbox" name="rencana[rehabilitasi_medik]" value="Rehabilitasi Medis"> &nbsp; <b>Rehabilitasi Medis</b>
                      
                    </td>
                  </tr>
                  <tr>
                   
                      <td>
                        <input type="text" placeholder="klinik" name="rencana[text]"  class="form-control" required>
                      </td>
                   
                  </tr>
                </td>
              </tr>  
              <tr> 
                <td>Dirujuk Ke</td>
                <td style="padding: 5px;">
                  <input type="text" name="rencana[dirujuk_ke]" class="form-control" required>
                </td>
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
                @if (isset($riwayat))
                @foreach (@$riwayat as $item)

                  <tr>
                    <td>Rencana</td>
                    <td> 
                      <b>rencana :</b> {{json_decode(@$item->rencana,true)['rencana']}}<br/>
                     
                     
                    </td> 
                </tr>
                <tr>
                  <td>Konsul Ke</td>
                  <td> 
                    <b>Spesialis Gizi Medik :</b> {{json_decode(@$item->rencana,true)['spesialis_gizi_klinik']}}<br/>
                    <b>Rehabilitasi Medis :</b> {{json_decode(@$item->rencana,true)['rehabilitasi_medik']}}<br/>
                    <b>Lainnya :</b> {{json_decode(@$item->rencana,true)['text']}}<br/>
                  </td>
                </tr>
                 <tr>
                  <td>Dirujuk Ke Ke</td>
                  <td> 
                    <b>Dirujuk Ke :</b> {{json_decode(@$item->rencana,true)['dirujuk_ke']}}<br/>
                  </td>
                </tr>
               
                
               
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                  </tr>
                @endforeach
                @endif
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
  @endsection